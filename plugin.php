<?php
namespace Amuz\XePlugin\DynamicFieldExtend;

use Amuz\XePlugin\DynamicFieldExtend\Middleware\CheckRequirePlugins;
use Route;
use XeLang;
use Xpressengine\Plugin\AbstractPlugin;
use Xpressengine\Config\ConfigEntity;

class Plugin extends AbstractPlugin
{
    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행됩니다.
     *
     * @return void
     */
    public function boot()
    {
        app('router')->pushMiddlewareToGroup('web', CheckRequirePlugins::class);

        // implement code
        $this->registerKeyChain();
        $this->route();
    }

    function registerKeyChain(){
        $keychain = [
            'kakao_map_key' => [
                'tab' => '확장필드',
                'group' => '지도',
                'label' => '카카오 지도 API KEY',
                'description' => '카카오 지도의 자바스크립트 키를 입력합니다.',
                'how' => '확장필드 위치 및 지도 필드에 활용됩니다.',
                'pid' => 'map',
                'vid' => 'kakao',
                'type' => 'formText',
                'ordering' => 500
            ],
            'naver_map_key' => [
                'tab' => '확장필드',
                'group' => '지도',
                'label' => '네이버 Client ID',
                'description' => '네이버 클라우드 플랫폼의 Client ID를 입력합니다.',
                'how' => '확장필드 위치 및 지도 필드에 활용됩니다.',
                'pid' => 'map',
                'vid' => 'naver',
                'type' => 'formText',
                'ordering' => 500
            ],
            'address_api_key' => [
                'tab' => '확장필드',
                'group' => '주소검색',
                'label' => '주소검색 API KEY',
                'description' => "주소 검색 API 키를 입력해주세요<br/> API 종류 -> 도로명 주소 API <br/> API 유형 -> 검색 API <br/> 발급주소 - <a href='https://www.juso.go.kr/addrlink/devAddrLinkRequestWrite.do?returnFn=write&cntcMenu=URL'>https://www.juso.go.kr/addrlink/devAddrLinkRequestWrite.do?returnFn=write&cntcMenu=URL</a>",
                'how' => '확장필드 위치 및 지도 필드에 활용됩니다.',
                'pid' => 'map',
                'vid' => 'addrlink',
                'type' => 'formText',
                'ordering' => 500
            ],
        ];
        \XeRegister::push('integrated_keychain',self::getId(),$keychain);
    }

    protected function route()
    {
        Route::settings(self::getId(), function () {
            Route::get('/', ['as' => 'manage.dynamic_field_extend.index', 'uses' => 'ManagerController@index']);
            Route::post('/', ['as' => 'manage.dynamic_field_extend.updateConfig', 'uses' => 'ManagerController@updateConfig']);
            //Route::get('/pointLog', ['as' => 'manage.dynamic_field_extendextend.point_log', 'uses' => 'ManagerController@pointLog']);

        }, ['namespace' => 'Amuz\XePlugin\DynamicFieldExtend\Controller']);
    }

    /**
     * 플러그인이 활성화될 때 실행할 코드를 여기에 작성한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function activate($installedVersion = null)
    {
        //xe_config설정값
        $configManager = app('xe.config');
        $config = $configManager->get('dynamic_field_extend');

        if ($config === null) {
            $config = new ConfigEntity();

            $config->set('hash_tag', 1);
            $config->set('media_library', 1);
            $config->set('color_picker', 1);
            $config->set('edittable', 1);
            $config->set('category_load', 1);
            $config->set('category_input', 1);
            $configManager->add('dynamic_field_extend', $config->getPureAll());
        }

    }

    /**
     * 플러그인을 설치한다. 플러그인이 설치될 때 실행할 코드를 여기에 작성한다
     *
     * @return void
     */
    public function install()
    {
    }

    /**
     * 해당 플러그인이 설치된 상태라면 true, 설치되어있지 않다면 false를 반환한다.
     * 이 메소드를 구현하지 않았다면 기본적으로 설치된 상태(true)를 반환한다.
     *
     * @return boolean 플러그인의 설치 유무
     */
    public function checkInstalled()
    {
        // implement code

        return parent::checkInstalled();
    }

    /**
     * 플러그인을 업데이트한다.
     *
     * @return void
     */
    public function update()
    {
        // implement code
    }

    /**
     * 해당 플러그인이 최신 상태로 업데이트가 된 상태라면 true, 업데이트가 필요한 상태라면 false를 반환함.
     * 이 메소드를 구현하지 않았다면 기본적으로 최신업데이트 상태임(true)을 반환함.
     *
     * @return boolean 플러그인의 설치 유무,
     */
    public function checkUpdated()
    {
        // implement code

        return parent::checkUpdated();
    }

    public function getSettingsURI()
    {
        //integrated keychain 으로 설정 통합
//        return route('manage.dynamic_field_extend.index');
        //return "";
    }
}
