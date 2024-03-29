<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\ColorPicker;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class ColorPickerField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/ColorPicker';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        //return 'ColorPicker - 색상';
        return 'Color picker - 색상';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '색상 선택 by Dynamic_field plugin.';
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
        return view('dynamic_field_extend::src/DynamicFields/ColorPicker/views/setting');
    }
}
