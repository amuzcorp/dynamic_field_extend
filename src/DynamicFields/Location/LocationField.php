<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Location;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class LocationField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/Map';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Location - 주소와 지도 좌표';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '주소 및 지도의 좌표를 지정 할 수 있습니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'postcode' => (new ColumnEntity('postcode', ColumnDataType::STRING))->setParams([8]),
            'jibun' => (new ColumnEntity('jibun', ColumnDataType::STRING))->setParams([255]),
            'doro' => (new ColumnEntity('doro', ColumnDataType::STRING))->setParams([255]),
            'detail' => (new ColumnEntity('detail', ColumnDataType::STRING))->setParams([255]),
            'lat' => (new ColumnEntity('lat', ColumnDataType::STRING))->setParams([255]),
            'lng' => (new ColumnEntity('lng', ColumnDataType::STRING))->setParams([255])
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
        return view('dynamic_field_extend::src/DynamicFields/Location/views/setting');
    }
}