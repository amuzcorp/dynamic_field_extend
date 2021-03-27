<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\MediaTable;

use Xpressengine\DynamicField\AbstractSkin;
use Amuz\XePlugin\DynamicFieldExtend\Plugin;
use Config;

class MediaTable extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return '미디어 라이브러리 fieldSkin';
        return 'Media library with Table';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.MediaTable.views';
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
        app('xe.frontend')->css([Plugin::asset('src/DynamicFieldSkins/MediaTable/assets/media_table.css')])->load();
        app('xe.frontend')->js([Plugin::asset('src/DynamicFieldSkins/MediaTable/assets/media_table.js')])->load();
        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if($config_dynamic->get('media_library') == 1) {
            return $viewFactory->make($this->getViewPath('create'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'config_dynamic' => $config_dynamic,
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
        list($data, $key) = $this->filter($args);
        $viewFactory = $this->handler->getViewFactory();
        //var_dump($args);
        //var_dump($this->config->get('id'));
        $media_name = $this->config->get('id').'_column';
        if(asset($args[$media_name])) {
            $media_data = $args[$media_name];
            $media_array = json_decode($media_data);
        }

        $storage_path = Config::get('filesystems.disks.media.url');

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');
        if($config_dynamic->get('media_library') == 1) {
            return $viewFactory->make($this->getViewPath('show'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'media' => $media_array,
                'storage_path' => $storage_path,
                'config_dynamic' => $config_dynamic,
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
        app('xe.frontend')->css([Plugin::asset('src/DynamicFieldSkins/MediaTable/assets/media_table.css')])->load();
        app('xe.frontend')->js([Plugin::asset('src/DynamicFieldSkins/MediaTable/assets/media_table.js')])->load();

        list($data, $key) = $this->filter($args);
        $viewFactory = $this->handler->getViewFactory();

        $media_name = $this->config->get('id') . '_column';
        if (asset($args[$media_name])) {
            $media_data = $args[$media_name];
            $media_array = json_decode($media_data);
        }

        $storage_path = Config::get('filesystems.disks.media.url');

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        if ($config_dynamic->get('media_library') == 1) {
            return $viewFactory->make($this->getViewPath('edit'), [
                'args' => $args,
                'config' => $this->config,
                'data' => array_merge($data, $this->mergeData),
                'key' => $key,
                'media' => $media_array,
                'storage_path' => $storage_path,
                'config_dynamic' => $config_dynamic,

            ])->render();
        }
    }
}
