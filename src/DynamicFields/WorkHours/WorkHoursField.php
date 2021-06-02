<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\WorkHours;

use Amuz\XePlugin\DynamicFieldExtend\Resources;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class WorkHoursField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/WorkHours';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        //return 'WorkHours fieldType';
        return 'Work hours - 운영시간';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'The fieldType supported by Dynamic_field_extend plugin.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        $columns = [];
        $columns['day_name'] = new ColumnEntity('day_name', ColumnDataType::STRING);
        $columns['day_name']->setDescription("기타일정인 경우 제목이 작성되고, 그게 아니면 요일 키값이 들어간다.");

        $columns['etc_date'] = new ColumnEntity('schedule_date', ColumnDataType::DATE);
        $columns['etc_date']->setDefault(null)->setNullAble()->setDescription('날짜는 지정된경우에만 조건절에 걸기위해서 쓴다.');

        $columns['morning_start'] = new ColumnEntity('morning_start', ColumnDataType::TIME);
        $columns['morning_end'] = new ColumnEntity('morning_end', ColumnDataType::TIME);
        $columns['afternoon_start'] = new ColumnEntity('afternoon_start', ColumnDataType::TIME);
        $columns['afternoon_end'] = new ColumnEntity('afternoon_end', ColumnDataType::TIME);

        return $columns;
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
        return view('dynamic_field_extend::src/DynamicFields/WorkHours/views/setting');
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
            throw new RequiredJoinColumnException;
        }

        $insertParam = [];
        $insertParam['field_id'] = $config->get('id');
        $insertParam['target_id'] = $args[$config->get('joinColumnName')];
        $insertParam['group'] = $config->get('group');

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key]) == true) {
                //var_dump(gettype($args[$key]));exit;
                if (gettype($args[$key]) == "array") {
                    $insertParam[$column->name] = json_encode($args[$key]);
                } else {
                    $insertParam[$column->name] = $args[$key];

                }
            }
        }

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
     * 생성된 Dynamic Field revision 테이블에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insertRevision(array $args)
    {
        if (isset($args['id']) === false) {
            throw new RequiredDynamicFieldException;
        }

        $insertParam = [];
        $insertParam['target_id'] = $args['id'];
        $insertParam['group'] = $this->config->get('group');
        $insertParam['field_id'] = $this->config->get('id');
        $insertParam['revision_id'] = $args['revision_id'];
        $insertParam['revision_no'] = $args['revision_no'];

//        foreach ($this->getColumns() as $column) {
//            $key = $this->config->get('id') . '_' . $column->name;
//
//            if (isset($args[$key])) {
//                $insertParam[$column->name] = $args[$key];
//            }
//        }

        foreach ($this->getColumns() as $column) {
            $key =  $this->config->get('id') . '_' . $column->name;

            if (isset($args[$key]) == true) {
                //var_dump(gettype($args[$key]));exit;
                if (gettype($args[$key]) == "array") {
                    $insertParam[$column->name] = json_encode($args[$key]);
                } else {
                    $insertParam[$column->name] = $args[$key];

                }
            }
        }

        $this->handler->connection()->table($this->getRevisionTableName())->insert($insertParam);
    }


    /**
     * 생성된 Dynamic Field 테이블에 데이터 수정
     *
     * @param array $args parameters
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
                if (gettype($args[$key]) == "array") {
                    $updateParam[$column->name] = json_encode($args[$key]);
                }else {
                    $updateParam[$column->name] = $args[$key];
                }
            }
        }

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
}
