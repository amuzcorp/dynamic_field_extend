<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\MediaSkin;

use Xpressengine\DynamicField\AbstractSkin;
use Config;

class MediaSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return '미디어 라이브러리 fieldSkin';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.MediaSkin.views';
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

        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'media' => $media_array,
            'storage_path' => $storage_path,
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
        $viewFactory = $this->handler->getViewFactory();

        $media_name = $this->config->get('id').'_column';
        if(asset($args[$media_name])) {
            $media_data = $args[$media_name];
            $media_array = json_decode($media_data);
        }

        $storage_path = Config::get('filesystems.disks.media.url');

        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'media' => $media_array,
            'storage_path' => $storage_path,
        ])->render();
    }
}
