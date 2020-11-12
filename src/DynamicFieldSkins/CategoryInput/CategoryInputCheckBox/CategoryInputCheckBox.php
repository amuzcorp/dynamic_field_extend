<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\CategoryInput\CategoryInputCheckBox;

use Xpressengine\DynamicField\AbstractSkin;

class CategoryInputCheckBox extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return 'CategoryInputCheckBox fieldSkin';
        return 'Category input checkbox';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.CategoryInput.CategoryInputCheckBox.views';
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

        //$cate_data = str_replace('\\n', '', $this->config->get('category_contents'));
        $cate_data = $this->config->get('category_contents');
        //$cate_explode = explode('<br/>',str_replace(' ','',nl2br($cate_data)));
        //$cate_explode = explode('<br/>',str_replace(' ','',nl2br($cate_data)));
        //$cate_explode = explode('<br />',nl2br($cate_data));
        $cate_explode = explode("\r\n",$cate_data);
        $cate_array = array();
        foreach ($cate_explode as $item){
            $item_explode = explode(":", $item);
            array_push($cate_array, $item_explode);
        }

        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_input') == 1) {
            return $viewFactory->make($this->getViewPath('create'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'cate' => $cate_array
            ])->render();
        }
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
        $cate_data = $this->config->get('category_contents');
        //$cate_explode = explode('<br />',nl2br($cate_data));
        $cate_explode = explode("\r\n",$cate_data);
        $cate_array = array();
        foreach ($cate_explode as $item){
            $item_explode = explode(":", $item);
            array_push($cate_array, $item_explode);
        }

        $my_data = null;
        if (isset($args[$this->config->get('id') . '_column'])) {
            $my_data = json_decode($args[$this->config->get('id') . '_column']);
        }

        list($data, $key) = $this->filter($args);
        $viewFactory = $this->handler->getViewFactory();

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_input') == 1) {
            return $viewFactory->make($this->getViewPath('edit'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'cate' => $cate_array,
                'data_array' => $my_data,
            ])->render();
        }
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
        $my_data = null;
        if (isset($args[$this->config->get('id') . '_column'])) {
            $my_data = json_decode($args[$this->config->get('id') . '_column']);
        }

        $cate_data = $this->config->get('category_contents');
        //$cate_explode = explode('<br />',nl2br($cate_data));
        $cate_explode = explode("\r\n",$cate_data);
        $cate_array = array();
        foreach ($cate_explode as $item){
            $item_explode = explode(":", $item);
            array_push($cate_array, $item_explode);
        }

        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('category_input') == 1) {
            return $viewFactory->make($this->getViewPath('show'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'cate' => $cate_array,
                'data_array' => $my_data,
            ])->render();
        }
    }
}
