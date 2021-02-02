<?php
namespace Amuz\XePlugin\DynamicFieldExtend\Widgets\Map;

use Xpressengine\Widget\AbstractWidget;

class MapWidget extends AbstractWidget
{
    protected static $path = 'dynamic_field_extend/src/Widgets/Map';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $widgetConfig = $this->setting();

        $unique_key = substr(str_replace('-', '', app('xe.keygen')->generate()), 0, 4);

        $title = $widgetConfig['@attributes']['title'];

        return $this->renderSkin([
            'widgetConfig' => $widgetConfig,
            'title' => $title,
            'unique_key' => $unique_key
        ]);
    }
}
