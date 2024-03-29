<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\InstanceSelector;

use Overcode\XePlugin\DynamicFactory\Models\CptDocument;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;

class InstanceSelectorField extends AbstractType
{

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Instance Selector - 인스턴스 선택';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '인스턴스를 선택하여 인스턴스 아이디를 저장합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'iid' => new ColumnEntity('iid', ColumnDataType::STRING)
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
        return view('dynamic_field_extend::src/DynamicFields/InstanceSelector/views/setting');
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
        return get_menu_instance_name($output);
    }
}
