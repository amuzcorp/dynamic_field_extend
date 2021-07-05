<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Location;

use Overcode\XePlugin\DynamicFactory\Models\CptDocument;
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


    /**
     * 관리자 페이지 목록을 출력하기 위한 함수.
     * CPT 목록에만 해당하며, 필드타입자체에 추가해주어야한다.
     *
     * @param string $id dynamic field name
     * @param CptDocument $doc arguments
     * @return string|null
     */
    public function getSettingListItem($id, CptDocument $doc){
        $args = $doc->getAttributes();
        $data = [];
        foreach ($this->getColumns() as $columnName => $columns) {
            $dataName = snake_case($id . '_' . $columnName);
            if (isset($args[$dataName])) {
                $data[$dataName] = $args[$dataName];
            } else {
                $data[$dataName] = '';
            }
        }
        if (count($data) == 0) {
            return null;
        }

        $output = implode(' ', $data);
        if (trim($output) == '') {
            return null;
        }

        return view('dynamic_field_extend::src/DynamicFields/Location/views/list-item',compact('id','data'));
    }
}
