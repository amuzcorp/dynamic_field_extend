<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\WorkHours;

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
        return view('dynamic_field_extend::src/DynamicFields/WorkHours/views/setting');
    }
}
