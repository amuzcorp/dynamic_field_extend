<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\WorkHoursDefault;

use Xpressengine\DynamicField\AbstractSkin;

class WorkHoursDefault extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Work hours default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.WorkHoursDefault.views';
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
