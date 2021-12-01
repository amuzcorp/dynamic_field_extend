<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\SignCanvasDefault;

use Xpressengine\DynamicField\AbstractSkin;
use Config;

class SignCanvasSkin extends AbstractSkin
{

    protected static $loaded = false;
    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return 'TableCheckBox fieldSkin';
        return 'Sign Canvas Default Skin';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.SignCanvasDefault.views';
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

    protected function appendScript()
    {
//        XeFrontend::js([
//            '//cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js'
//        ])->location('body.prepend')->loadAsync()->load();
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

        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

        list($data, $key) = $this->filter($args);

        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
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

        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }


    /**
     * 데이터 출력
     *
     * @param string $name dynamic field name
     * @param array  $args 데이터
     * @return mixed
     */
    public function output($name, array $args)
    {
        if (isset($args[$name.'_text']) && isset($args[$name.'_signature_date'])) {
            if ($args[$name.'_text'] === '' || !$args[$name.'_signature_date']) {
                return '<span style="color:#ff2831;">서명없음</span>';
            } else {
                return '<span style="color:#0049ff;">서명확인</span>';
            }
        }
        return '<span style="color:#ff2831;">서명없음</span>';
    }

}
