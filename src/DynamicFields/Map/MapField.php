<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Map;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class MapField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/Map';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        //return 'Map fieldType';
        return 'Map - 지도';
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
//        return [
//            'column'=>new ColumnEntity('column', ColumnDataType::STRING),
//            'column2'=>new ColumnEntity('column2', ColumnDataType::TEXT)
//
//        ];
        return [
            'auto_center' => new ColumnEntity('auto_center', ColumnDataType::STRING),
            'list_display' => new ColumnEntity('list_display', ColumnDataType::STRING),
            'zoom_level' => new ColumnEntity('zoom_level', ColumnDataType::INTEGER),
            'center_location' => new ColumnEntity('center_location', ColumnDataType::TEXT),
            'location_data' => new ColumnEntity('location_data', ColumnDataType::TEXT),
            'location_info' => new ColumnEntity('location_info', ColumnDataType::TEXT),

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
        return view('dynamic_field_extend::src/DynamicFields/Map/views/setting');
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        $required = $this->config->get('required') === true;

        $rules = [];
        $names = array_map(function () {
            return '';
        }, $this->getColumns());

        foreach (array_merge($names, $this->rules) as $name => $rule) {
            $key = $this->config->get('id') . '_' . $name;
            if ($required == true) {
                if($name == "auto_center" || $name=="center_location" || $name="zoom_level"){
                    $rules[$key] = 'nullable|' . $rule;
                }else {
                    $rules[$key] = ltrim($rule . '|required', '|');
                }
            } else {
                $rules[$key] = 'nullable|' . $rule;
            }
        }

        if ($required == true) {
            $key = $this->config->get('id') . '_' . "location_data";
            $rules[$key] = ltrim($rule . '|required', '|');
        }

        return $rules;
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

            if ($column->name == "list_display") {
                if (!isset($args[$key])) {
                    $args[$key] = "off";
                }
            }


            if ($column->name == "auto_center") {
                if (!isset($args[$key])) {
                    $args[$key] = "off";
                }
            }

            if (isset($args[$key]) == true) {
                if (($column->name == "location_data") || $column->name == "location_info") {
                    $insertParam[$column->name] = json_encode($args[$key]);
                } else {
                    $insertParam[$column->name] = $args[$key];
                }
                //$insertParam[$column->name] = $args[$key];
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

        foreach ($this->getColumns() as $column) {
            $key = $this->config->get('id') . '_' . $column->name;

            if ($column->name == "list_display") {
                if (!isset($args[$key])) {
                    $args[$key] = "off";
                }
            }

            if ($column->name == "auto_center") {
                if (!isset($args[$key])) {
                    $args[$key] = "off";
                }
            }

//            if (isset($args[$key])) {
//                $insertParam[$column->name] = $args[$key];
//            }
            if (isset($args[$key]) == true) {
                if (($column->name == "location_data") || $column->name == "location_info") {
                    $insertParam[$column->name] = json_encode($args[$key]);
                } else {
                    $insertParam[$column->name] = $args[$key];
                }
                //$insertParam[$column->name] = $args[$key];
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

                //$updateParam[$column->name] = $args[$key];
                if (($column->name == "location_data") || $column->name == "location_info") {
                    $updateParam[$column->name] = json_encode($args[$key]);
                } else {
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
