<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\VimeoClipSelectorDefault;

use Amuz\XePlugin\DynamicFieldExtend\Models\VimeoVideo;
use Xpressengine\DynamicField\AbstractSkin;
use Config;
use Amuz\XePlugin\DynamicFieldExtend\Models\VimeoDirectory;

class VimeoClipSelectorDefault extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return '비메오 영상 셀렉터 기본스킨';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.VimeoClipSelectorDefault.views';
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

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        $vimeoDirectories = VimeoDirectory::get();

        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'directories' => $vimeoDirectories
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

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');

        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
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

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field_extend');
        $responseData = array_merge($data, $this->mergeData);

        //비메오 디렉토리
        $vimeoDirectories = VimeoDirectory::get();

        $selectedVideoList = [];

        if($responseData['vimeo_ids'] !== '') {
            $selected = explode(',', $responseData['vimeo_ids']);
            $selectedVideoList = VimeoVideo::whereIn('id', $selected)->get();

            foreach($selectedVideoList as $key => $item) {
                $selectedVideoList[$key]->directory_name = $this->getVideoDirectoryName($item->id);
            }
        }

        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'selected' => $selectedVideoList,
            'directories' => $vimeoDirectories
        ])->render();
    }

    public function getVideoDirectoryName($videoId) {
        return VimeoVideo::where('vimeo_video.id', $videoId)->leftJoin('vimeo_directory','vimeo_video.directory_id', '=', 'vimeo_directory.id')->select('vimeo_directory.*')->value('name');
    }
}
