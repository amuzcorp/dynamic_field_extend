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
}
