<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\TextTranslationSkin;

use Xpressengine\DynamicField\AbstractSkin;
use Config;

class TextTranslationSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return 'TableCheckBox fieldSkin';
        return 'Text Field Translation Skin';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.TextTranslationSkin.views';
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

    public function output($id, array $args)
    {
        $data = [];
        foreach ($this->getType()->getColumns() as $columnName => $columns) {
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

        $output = xe_trans('laravel::'.implode($this->glue, $data)) ?: '';

        if (trim($output) == '') {
            return null;
        }

        return $output;
    }
}
