<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\InstanceSelector\Skins\Basic;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Routing\InstanceRoute;

class BasicSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'basic - 기본 스킨';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFields.InstanceSelector.Skins.Basic.views';
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
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $menu_items = $this->getMenuItems();

        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'menu_items' => $menu_items
        ])->render();
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        list($data, $key) = $this->filter($args);

        $menu_items = $this->getMenuItems();

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'menu_items' => $menu_items
        ])->render();
    }

    /**
     * 조회할 때 사용 될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function show(array $args)
    {
        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }

    protected function getMenuItems()
    {
        $hasSiteKey = \Schema::hasColumn('menu_item', 'site_key');

        $menus = [];

        if($hasSiteKey) {
            $menu_items = MenuItem::where('site_key', \XeSite::getCurrentSiteKey())->orderBy('ordering')->get();
        }else {
            $menu_items = MenuItem::orderBy('ordering')->get();
        }
        foreach ($menu_items as $menu_item) {
            $menus[$menu_item->id] = $menu_item->title;
        }
        if(\XeSite::getCurrentSiteKey() == 'default') {
            $menus['dashboard'] = '관리자 대시보드';
        }

        return $menus;
    }
}
