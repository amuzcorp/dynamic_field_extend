<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Tag;

use Xpressengine\Config\ConfigEntity;
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
        //return 'Hashtag fieldType';
        return 'Tag - 태그';
        //return "Hashtag -".($this->getId());

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
            'column'=>new ColumnEntity('column', ColumnDataType::STRING)
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
//        dd($args, 1);
        if(isset($args['_tags'])) {
            $this->set($args['id'], $args['_tags'], $args['instance_id']);
        }
    }

    public function insertRevision(array $args)
    {

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
        //$repo = new TagRepository();
        //$repo->detach()
        /*
        foreach ($wheres as $data){
            $tags = \XeTag::fetchByTaggable($data['value']);
            \XeTag::detach($data['value'], $tags);
        }
        */
        foreach ($wheres as $data){
            $this->set($data['value']);
        }
    }

    public function set($taggableId, array $words = [], $instanceId = null)
    {
        $repo = new TagRepository();
        $decomposer = new SimpleDecomposer();
        $words = array_unique($words);

        $tags = $repo->query()->where('instance_id', $instanceId)->whereIn('word', $words)->get();

        // 등록되지 않은 단어가 있다면 등록 함
        foreach (array_diff($words, $tags->pluck('word')->all()) as $word) {
            $tag = $repo->create([
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

}
