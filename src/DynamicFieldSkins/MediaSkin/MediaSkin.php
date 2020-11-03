<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\MediaSkin;

use Xpressengine\DynamicField\AbstractSkin;

class MediaSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return '미디어 라이브러리 fieldSkin';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.MediaSkin.views';
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
