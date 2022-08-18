<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Calendar\Skins\AmuzDefault;

use Xpressengine\DynamicField\AbstractSkin;

class AmuzDefaultSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Calendar Default Skin';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src/DynamicFields/Calendar/Skins/AmuzDefault/views';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * 데이터 출력
     *
     * @param string $id   dynamic field name
     * @param array  $args arguments
     * @return string|null
     */
    public function output($id, array $args)
    {
        $data = [];

        foreach ($this->getType()->getColumns() as $columnName => $columns) {
            if($this->config->get('time_type') == 'single' && $columnName == 'end') {
                continue;
            }
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

        $output = implode($this->glue, $data);

        if (trim($output) == '') {
            return null;
        }

        return $output;
    }
}
