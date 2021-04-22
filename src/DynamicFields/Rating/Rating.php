<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Rating;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class Rating extends AbstractType
{
    protected static $path = 'dynamic_field_extend/src/DynamicFields/Rating';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Number 평점계산';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'The fieldType supported by Dynamic_field plugin.';
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
        $field_list = \DB::table('config')->select(\DB::raw('SubString_Index(name , "." , -1) as field_id'))->where('site_key',\XeSite::getCurrentSiteKey())->where('vars','like','%"skinId":"fieldType\\\\/xpressengine@Number\\\\/fieldSkin\\\\/dynamic_field_extend@RatingStar"%')->pluck('field_id');
        return view('dynamic_field_extend::src/DynamicFields/Rating/views/setting',['field_list' => $field_list]);
    }

}
