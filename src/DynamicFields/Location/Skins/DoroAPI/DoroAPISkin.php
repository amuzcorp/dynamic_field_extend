<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Location\Skins\DoroAPI;

use Xpressengine\DynamicField\AbstractSkin;

class DoroAPISkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'api - 도로명 검색 API 스킨';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFields.Location.Skins.DoroAPI.views';
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
     */
    public function create(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $map_key = app('amuz.keychain')->getValueById('kakao_map_key');
        $address_key = app('amuz.keychain')->getValueById('address_api_key');

        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'map_key' => $map_key,
            'address_key' => $address_key
        ])->render();
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     */
    public function edit(array $args)
    {
        list($data, $key) = $this->filter($args);

        $map_key = app('amuz.keychain')->getValueById('kakao_map_key');
        $address_key = app('amuz.keychain')->getValueById('address_api_key');

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'map_key' => $map_key,
            'address_key' => $address_key
        ])->render();
    }

    /**
     * 조회할 때 사용 될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     */
    public function show(array $args)
    {
        list($data, $key) = $this->filter($args);

        $map_key = app('amuz.keychain')->getValueById('kakao_map_key');

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'map_key' => $map_key
        ])->render();
    }
}
