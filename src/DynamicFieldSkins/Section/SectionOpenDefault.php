<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\Section;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Tag\TagRepository;

class SectionOpenDefault extends AbstractSkin
{
    protected static $loaded = false;

    public $urlHandler;

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Section Open default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.Section.open.views';
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

    public function create(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        return $viewFactory->make($this->getViewPath('create'),['config' => $this->config])->render();
    }

    public function show(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('show'))->render();
    }

    //AbstractSkin Class edit메서드 오버라이딩
    public function edit(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        return $viewFactory->make($this->getViewPath('edit'),['config' => $this->config])->render();
    }


}
