<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Tag;
use Schema;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Schema\Blueprint;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Tag\SimpleDecomposer;
use Xpressengine\Tag\Tag;
use Xpressengine\Tag\TagHandler;
use Xpressengine\Tag\TagRepository;
use Xpressengine\Tag\Decomposer;
use Xpressengine\DynamicField\DynamicFieldExtendHandler;

class TagField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/Tag';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Tag - 태그';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        //return 'The fieldType supported by Dynamic_field plugin.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'word' => (new ColumnEntity('word', ColumnDataType::STRING))->setParams([100]),
            'decomposed' => (new ColumnEntity('decomposed', ColumnDataType::STRING))->setParams([255]),
            'count' => (new ColumnEntity('count', ColumnDataType::INTEGER))->setParams([11])->setUnsigned(),
            'site_key' => (new ColumnEntity('site_key', ColumnDataType::STRING))->setParams([50])
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * get dynamic field table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'taggables';
    }


    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getSettingsView(ConfigEntity $config = null)
    {
        return view('dynamic_field_extend::src/DynamicFields/Tag/views/setting');
    }

    public function insert(array $args)
    {
        $this->checkAndModifyTagTable();
        if(isset($args['_tags'])) {
            $this->set($args['id'], $args['_tags'], $args['instance_id']);
        }
    }

    public function checkAndModifyTagTable(){
        if(Schema::hasColumn('taggables', 'field_id') === false){
            Schema::table('taggables', function (Blueprint $table) {
                $table->string('field_id', 36)->nullable()->after('taggable_id');
            });
        }
    }

    public function update(array $args, array $wheres)
    {
        //var_dump($args);var_dump($wheres);exit;
        if(isset($args['doc_id']) && isset($args['_tags'])) {
            $this->set($args['doc_id'], $args['_tags'], $args['cpt_id']);
        }
    }

    public function delete(array $wheres)
    {
        foreach ($wheres as $data){
            $this->set($data['value']);
        }
    }

    /**
     * delete dynamic field all data
     *
     * @return void
     */
    public function dropData()
    {
        $where  = [
            ['instance_id', $this->config->get('id', '')],
            ['group', $this->config->get('group', '')]
        ];

        $this->handler->connection()->table($this->getTableName())
            ->where($where)->delete();
    }

    public function set($taggableId, array $words = [], $instanceId = null)
    {
        $repo = new TagRepository();
        $decomposer = new SimpleDecomposer();
        $words = array_unique($words);

        $tags = $repo->query()->where('instance_id', $instanceId)
            ->where('group',$taggableId)->whereIn('word', $words)->get();

        // 등록되지 않은 단어가 있다면 등록 함
        foreach (array_diff($words, $tags->pluck('word')->all()) as $word) {
            $tag = $repo->create([
                'group' => $taggableId,
                'word' => $word,
                'decomposed' => $decomposer->execute($word),
                'instance_id' => $instanceId,
            ]);

            $tags->push($tag);
        }

        // 넘겨준 태그와 대상 아이디를 연결
        $tags = $this->multisort($words, $tags->all());
        $repo->attach($taggableId, $tags);

        // 이전에 대상 아이디에 연결된 태그중
        // 전달된 단어 해당하는 태그가 없는경우 연결 해제 처리
        $olds = $repo->fetchByTaggable($taggableId);
        $removes = $olds->diff($tags);

        $repo->detach($taggableId, $removes);

        return $repo->newCollection($tags);
    }

    private function multisort($std, $tags)
    {
        $std = array_map([$this, 'nonNumeric'], array_values($std));
        $words = array_map(function ($tag) {
            return $this->nonNumeric($tag->word);
        }, $tags);

        $index = array_merge(array_flip($words), array_flip($std));
        array_multisort($index, $tags);

        return $tags;
    }

    private function nonNumeric($v)
    {
        return is_numeric($v) ? '_'.$v : $v;
    }

    /**
     * create dynamic field tables
     *
     * @return void
     */
    public function createTypeTable()
    {
        //테이블을 생성하지 않는다.
    }

    /**
     * table join
     *
     * @param DynamicQuery $query  query builder
     * @param ConfigEntity $config config entity
     * @return Builder
     */
    public function join(DynamicQuery $query, ConfigEntity $config = null)
    {
        if ($config === null) {
            $config = $this->config;
        }

        if ($config->get('use') === false) {
            return $query;
        }

        $baseTable = $query->from;

        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));
        $tablePrefix = $this->handler->connection()->getTablePrefix();

        if ($query->hasDynamicTable($config->get('group') . '_' . $config->get('id')) === true) {
            return $query;
        }

        //check column
        $this->checkAndModifyTagTable();
        $createTableName = 'dynamic_tags';
        $sub_query = \DB::table('taggables')
                    ->selectRaw(sprintf('%staggables.taggable_id as `target_id`, %1$stags.instance_id as `group`, %1$staggables.field_id as `field_id`,%1$stags.word as `word`',$tablePrefix))
                    ->leftJoin('tags','taggables.tag_id','=','tags.id');
        //서브쿼리 확인
//        $obj = $sub_query->get();
//        dd($obj);

        $column_name = 'word';
        $key = $config->get('id') . '_' . $column_name;

        $rawString = sprintf('%s.*', $tablePrefix . $baseTable);
        $rawString .= sprintf(', GROUP_CONCAT(distinct %s.%s SEPARATOR \',\') as %s', $tablePrefix.$createTableName, $column_name, $key);

        $query->leftJoin(\DB::raw(sprintf("(%s) as %s",$sub_query->toSql(),$tablePrefix.$createTableName)),
            function (JoinClause $join) use ($createTableName, $config, $baseTable,$sub_query) {
                $join->on(
                    sprintf('%s.%s', $baseTable, $config->get('joinColumnName')),
                    '=',
                    sprintf('%s.target_id', $createTableName)
                )->where($createTableName . '.field_id', $config->get('id'));
            }
        )->selectRaw($rawString);

        $query->setDynamicTable($config->get('group') . '_' . $config->get('id'));

        return $query;
    }
}
