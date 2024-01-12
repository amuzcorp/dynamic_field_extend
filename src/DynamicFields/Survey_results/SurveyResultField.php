<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Survey_results;

use Overcode\XePlugin\DynamicFactory\Models\CptDocument;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Menu\Models\MenuItem;

class SurveyResultField extends AbstractType
{
    protected static $path = 'dynamic_field_extend/src/DynamicFields/Survey_results';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return '설문조사 결과 Fields';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '설문조사 결과입니다';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'doc_id' => new ColumnEntity('doc_id', ColumnDataType::STRING),
            'result' => new ColumnEntity('result', ColumnDataType::TEXT),
            'update_date' => new ColumnEntity('update_date', ColumnDataType::STRING),
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
        return view('dynamic_field_extend::src/DynamicFields/Survey_results/views/setting',[
            'config' => $config,
            'iids' => $this->getInstanceIds()
        ]);
    }

    /**
     * 생성된 Dynamic Field 테이블에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insert(array $args)
    {
        $config = $this->config;

        if (isset($args[$config->get('joinColumnName')]) === false) {
            throw new Exceptions\RequiredJoinColumnException;
        }

        $insertParam = [];
        $insertParam['field_id'] = $config->get('id');
        $insertParam['target_id'] = $args[$config->get('joinColumnName')];
        $insertParam['group'] = $config->get('group');

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;
            if (isset($args[$key]) == true) {
                if($column->name !== 'update_date')
                    $insertParam[$column->name] = $args[$key];
                else {

                }
            }
        }
        $insertParam['update_date'] = date('Y-m-d H:i:s');

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_insert', $config->get('group'), $config->get('id'))
        );

        if (count($insertParam) > 1) {
            $this->handler->connection()->table($this->getTableName())->insert($insertParam);
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_insert', $config->get('group'), $config->get('id'))
        );
    }

    /**
     * 생성된 Dynamic Field 테이블에 데이터 수정
     *
     * @param array $args   parameters
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres)
    {
        $config = $this->config;
        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));

        $where = $this->getWhere($wheres, $config);

        if (isset($where['target_id']) === false) {
            return null;
        }

        foreach ($args as $index => $arg) {
            if ($arg == null) {
                $args[$index] = '';
            }
        }

        $updateParam = [];

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                if($column->name !== 'update_date')
                    $updateParam[$column->name] = $args[$key]; // 배열이 json 형태로 들어옴
                else {

                }
            }
        }
        $updateParam['update_date'] = date('Y-m-d H:i:s');

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_update', $config->get('group'), $config->get('id'))
        );

        if (count($updateParam) > 0) {
            if ($this->handler->connection()->table($type->getTableName())
                    ->where($where)->first() != null
            ) {
                $this->handler->connection()->table($type->getTableName())
                    ->where($where)->update($updateParam);
            } else {
                $insertParam = $updateParam;
                $insertParam['target_id'] = $where['target_id'];
                $insertParam['field_id'] = $config->get('id');
                $insertParam['group'] = $config->get('group');

                $this->handler->connection()->table($type->getTableName())
                    ->insert($insertParam);
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_update', $config->get('group'), $config->get('id'))
        );
    }

    /**
     * 생성된 Dynamic Field revision 테이블에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insertRevision(array $args)
    {
        if (isset($args['id']) === false) {
            throw new Exceptions\RequiredDynamicFieldException;
        }

        $insertParam = [];
        $insertParam['target_id'] = $args['id'];
        $insertParam['group'] = $this->config->get('group');
        $insertParam['field_id'] = $this->config->get('id');
        $insertParam['revision_id'] = $args['revision_id'];
        $insertParam['revision_no'] = $args['revision_no'];

        foreach ($this->getColumns() as $column) {
            $key = $this->config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $insertParam[$column->name] = json_encode($args[$key]); // 배열의 형태이기 때문에 json 으로 저장
            }
        }

        $this->handler->connection()->table($this->getRevisionTableName())->insert($insertParam);
    }

    protected function getInstanceIds()
    {
        $cpts = app('overcode.df.service')->getItemsAll();
//        $query = MenuItem::Where('type','board@board');
//        if(\Schema::hasColumn('menu_item', 'site_key')) $query = $query->where('site_key', \XeSite::getCurrentSiteKey());
//        $boards = $query->orderBy('ordering')->get();

        $iids = [];

        foreach ($cpts as $cpt) $iids[$cpt->cpt_id] = ['type' => 'cpt', 'id' => $cpt->cpt_id, 'name' => $cpt->cpt_name];

        return $iids;
    }

}
