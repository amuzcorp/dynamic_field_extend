<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\CategoryLoad\CategoryLoadCheckBox;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;

class CategoryLoadCheckBox extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Category load checkbox';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.CategoryLoad.CategoryLoadCheckBox.views';
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
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }

        $category = Category::find($this->config->get('category_load'));
        $this->addMergeData(['categoryItems' => $category->items]);
        $my_data = $this->mergeData;
        //var_dump($my_data['categoryItems'][0]);exit;
        $items = $my_data['categoryItems'];
        //var_dump($items);

        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_load') == 1) {
            return $viewFactory->make($this->getViewPath('create'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'items' => $items,
            ])->render();
        }
        //return parent::create($args);
    }

    public function show(array $args)
    {
        $item = null;
        if (isset($args[$this->config->get('id') . '_item_id'])) {
            $my_data = json_decode($args[$this->config->get('id') . '_item_id']);
            $item = CategoryItem::find($my_data);
        }


        $this->addMergeData([
            'categoryItem' => $item,
        ]);

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_load') == 1) {
            return parent::show($args);
        }
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }

        //$category = Category::find($this->config->get('category_id'));
        $category = Category::find($this->config->get('category_load'));

        $item = null;
        $my_array = null;
        if (isset($args[$this->config->get('id') . '_item_id'])) {
            $my_array = json_decode($args[$this->config->get('id') . '_item_id']);
            $item = CategoryItem::find($my_array);
        }

        $this->addMergeData([
            'categoryItems' => $category->items,
            'categoryItem' => $item,
        ]);

        $my_data = $this->mergeData;
        $items = $my_data['categoryItems'];
        $itemId = null;
        if(isset($my_data['categoryItem'])) {
            $itemId = $my_array;
        }
        list($data, $key) = $this->filter($args);
        $viewFactory = $this->handler->getViewFactory();

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_load') == 1) {
            return $viewFactory->make($this->getViewPath('edit'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'items' => $items,
                'itemId' => $itemId,
            ])->render();
        }

        //return parent::edit($args);
    }
}
