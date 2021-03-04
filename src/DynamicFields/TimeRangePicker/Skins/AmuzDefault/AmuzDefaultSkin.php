<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\TimeRangePicker\Skins\AmuzDefault;

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
        return '기본 스킨';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src/DynamicFields/TimeRangePicker/Skins/AmuzDefault/views';
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
