<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\CategoryLoad\CategoryLoadDepth;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Config\ConfigEntity;


class CategoryLoadDepth extends AbstractSkin
{

    public $cate_string = "";
    public $cate_hi = 0;
    public $cate_array = array();

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return 'Categoryloadskin fieldSkin';
        //return '카테고리 불러오기 셀렉트 박스 fieldSkin';
        return 'Category load Depth';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.CategoryLoad.CategoryLoadDepth.views';
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

        //===============계층 표시해서 카테고리 데이터 가져오기
        $categories = $this->getCategoryItemsTree($this->config);
        $this->cate_select($categories);
        //===============

        //====계층 표시 없이 카테고리 데이터 가져오기
//        $category = Category::find($this->config->get('category_load'));
//        $this->addMergeData(['categoryItems' => $category->items]);
//        $my_data = $this->mergeData;
//        $items = $my_data['categoryItems'];
        //====

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
                'categories' => $categories,
                'items' => $this->cate_array,
            ])->render();
        }
        //return parent::create($args);
    }

    public function show(array $args)
    {
        $item = null;
        if (isset($args[$this->config->get('id') . '_item_id'])) {
            $item = CategoryItem::find(json_decode($args[$this->config->get('id') . '_item_id']));
        }

        $this->addMergeData([
            'categoryItem' => $item,
        ]);

        //===============계층 표시해서 카테고리 데이터 가져오기
        $categories = $this->getCategoryItemsTree($this->config);
        $this->cate_select($categories);
        //===============

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_load') == 1) {

            list($data, $key) = $this->filter($args);

            $datas = array_merge($data, $this->mergeData);

            $selectItem = [];
            $sub_categories = [];
            $selectedItemCollection = [];

            if(isset($datas['item_id']) && $datas['item_id'] !== "[]" && $datas['item_id'] !== "") {
                $selectItem = json_decode($datas['item_id']);
                $selectItem = json_decode($selectItem);

                foreach ($selectItem as $value) {
                    $selectedItemCollection[$value] = CategoryItem::where('id', $value)->first();
                }

                $args['selectedItemCollection'] = $selectedItemCollection;
                foreach ($selectedItemCollection as $key => $item) {
                    $getItems = CategoryItem::where('parent_id', $item->id)->get();
                    if(count($getItems) !== 0) {
                        foreach ($getItems as $getItem) {
                            $getItem['child'] = false;
                            if (CategoryItem::where('parent_id', $getItem->id)->count() > 0) {
                                $getItem['child'] = true;
                            }
                        }
                    }

                    $sub_categories[$item->id] = $getItems;
                }
            }

            $viewFactory = $this->handler->getViewFactory();
            return $viewFactory->make($this->getViewPath('show'), [
                'args' => $args,
                'config' => $this->config,
                'data' => $datas,
                'selectedItemCollection' => $selectedItemCollection,
                'sub_categories' => $sub_categories,
                'categories' => $categories,
                'key' => $key,
                'value'=> $selectItem
            ])->render();

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
        if (isset($args[$this->config->get('id') . '_item_id'])) {
            $item = CategoryItem::find(json_decode($args[$this->config->get('id') . '_item_id']));
        }

        if(isset($category->items)) {
            $this->addMergeData([
                'categoryItems' => $category->items,
                'categoryItem' => $item,
            ]);
        }

        $my_data = $this->mergeData;
        //$items = $my_data['categoryItems'];

        //===============계층 표시해서 카테고리 데이터 가져오기
        $categories = $this->getCategoryItemsTree($this->config);
        $this->cate_select($categories);
        $items = $this->cate_array;
        //===============

        $itemId = null;
        if(isset($my_data['categoryItem']['id'])) {
            $itemId = $my_data['categoryItem']['id'];
        }
        list($data, $key) = $this->filter($args);
        $datas = array_merge($data, $this->mergeData);

        $selectedItemCollection = [];
        $sub_categories = [];

        $selectItem = [];

        if(isset($datas['item_id']) && $datas['item_id'] !== "[]" && $datas['item_id'] !== "") {
            $selectItem = json_decode($datas['item_id']);
            $selectItem = json_decode($selectItem);

            $sub_categories = [];
            $selectedItemCollection = [];
            foreach ($selectItem as $value) {
                $selectedItemCollection[$value] = CategoryItem::where('id', $value)->first();
            }

            $args['selectedItemCollection'] = $selectedItemCollection;
            foreach ($selectedItemCollection as $key => $item) {
                $getItems = CategoryItem::where('parent_id', $item->id)->get();
                if(count($getItems) !== 0) {
                    foreach ($getItems as $getItem) {
                        $getItem['child'] = false;
                        if (CategoryItem::where('parent_id', $getItem->id)->count() > 0) {
                            $getItem['child'] = true;
                        }
                    }
                }

                $sub_categories[$item->id] = $getItems;
            }
        }

        $viewFactory = $this->handler->getViewFactory();

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_load') == 1) {
            return $viewFactory->make($this->getViewPath('edit'), [
                'args' => $args,
                'config' => $this->config,
                'selectedItemCollection' => $selectedItemCollection,
                'sub_categories' => $sub_categories,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'items' => $items,
                'categories' => $categories,
                'itemId' => $itemId,
                'value'=> $selectItem
            ])->render();
        }

        //return parent::edit($args);
    }


    /**
     * get category item tree
     *
     * @param ConfigEntity $config board config entity
     * @return array
     */
    public function getCategoryItemsTree(ConfigEntity $config)
    {
        $items = [];
        if ($config->get('category_load') !== null) {
            $categoryItems = CategoryItem::where('category_id', $config->get('category_load'))
                ->where('parent_id', null)
                ->orderBy('ordering')->get();

            foreach ($categoryItems as $categoryItem) {
                $categoryItemData = [
                    'value' => $categoryItem->id,
                    'text' => xe_trans($categoryItem->word),
                    'children' => $this->getCategoryItemChildrenData($categoryItem)
                ];

                $items[] = $categoryItemData;
            }

        }

        return $items;
    }

    /**
     * get category item data
     *
     * @param CategoryItem $categoryItem target category
     *
     * @return array
     */
    private function getCategoryItemChildrenData(CategoryItem $categoryItem)
    {
        $children = $categoryItem->getChildren();

        if ($children->isEmpty() === true) {
            return [];
        }

        $childrenData = [];
        foreach ($children as $child) {
            $childrenData[] = [
                'value' => $child->id,
                'text' => xe_trans($child->word),
                'children' => $this->getCategoryItemChildrenData($child)
            ];
        }

        return $childrenData;
    }



    public function cate_select($my_data){
        for($i=0;$i<count($my_data);$i++){
            //$this->cate_string .= "<option value=".$my_data[$i]['value'].">".$this->cate_grade_str($this->cate_hi++).$this->child_chk($this->cate_hi).$my_data[$i]['text']."</option>";
            $temp_array = array($my_data[$i]['value'],$this->cate_grade_str($this->cate_hi++).$this->child_chk($this->cate_hi).$my_data[$i]['text']);
            array_push($this->cate_array,$temp_array);
            $temp_array = null;
            for ($j=0;$j<count($my_data[$i]['children']);$j++){
               // $this->cate_string .= "<option value=".$my_data[$i]['children'][$j]['value'].">".$this->cate_grade_str($this->cate_hi++).$this->child_chk($this->cate_hi).$my_data[$i]['children'][$j]['text']."</option>";
                $temp_array = array($my_data[$i]['children'][$j]['value'], $this->cate_grade_str($this->cate_hi++).$this->child_chk($this->cate_hi).$my_data[$i]['children'][$j]['text']);
                array_push($this->cate_array, $temp_array);
                $temp_array = null;
                $this->cate_select($my_data[$i]['children'][$j]['children']);
                $this->cate_hi--;
            }
            $this->cate_hi--;
        }
    }

    public function cate_grade_str($my_grade){
        $my_grade_str = "";
        for($i=0;$i<$my_grade;$i++){
            $my_grade_str.="&nbsp;&nbsp;&nbsp;";
        }

        return $my_grade_str;
    }

    public function child_chk($my_grade){
        if($my_grade == 0 or $my_grade == 1){
            return "";
        }else{
            return "└";
        }
    }

}//class CategoryLoadDepth end
