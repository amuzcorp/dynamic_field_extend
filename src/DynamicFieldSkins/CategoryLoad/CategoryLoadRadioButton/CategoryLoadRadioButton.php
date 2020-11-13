<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\CategoryLoad\CategoryLoadRadioButton;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;

class CategoryLoadRadioButton extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return 'CategoryloadRadio fieldSkin';
        //return '카테고리 불러오기 라디오 버튼 fieldSkin';
        return 'Category load radiobutton';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.CategoryLoad.CategoryLoadRadioButton.views';
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
        $this->setCategoryId();

        $this->addMergeData(['items' => $this->getCategoryItems()]);


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
            ])->render();
        }

        //return parent::create($args);
    }

    /**
     * 카테고리 ID를 config에 공통된 이름으로 설정
     *
     * @return void
     */
    private function setCategoryId()
    {
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }
    }

    /**
     * 확장필드에 지정된 Category를 가져옴
     *
     * @return array
     */
    private function getCategoryItems()
    {
        $items = [];
        $categoryItems = Category::find($this->config->get('category_load'))->items;
        foreach ($categoryItems as $categoryItem) {
            $items[] = [
                'value' => $categoryItem->id,
                'text' => $categoryItem->word,
            ];
        }

        return $items;
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
//        $this->setCategoryId();
//
//        $items = $this->getCategoryItems();
//        $selectedCategoryItemId = $args[$this->config->get('id') . '_item_id'];
//        $selectedItemText = '';
//        //var_dump($items);
//        foreach ($items as $item) {
//            var_dump($item['value']);
//            var_dump(json_decode($selectedCategoryItemId));
//            if ($item['value'] == json_decode($selectedCategoryItemId)) {
//                $selectedItemText = $item['text'];
//            }
//        }
//
//        $this->addMergeData(['selectedItemText' => $selectedItemText]);
        //var_dump(json_decode($args[$this->config->get('id') . '_item_id']));

        //var_dump($args);
        $item = null;
        if (isset($args[$this->config->get('id') . '_item_id'])) {
            $item = CategoryItem::find(json_decode($args[$this->config->get('id') . '_item_id']));
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
        $this->setCategoryId();

        $this->addMergeData(['items' => $this->getCategoryItems()]);

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_load') == 1) {
            return parent::edit($args);
        }
    }
}
