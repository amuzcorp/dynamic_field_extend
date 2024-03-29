<?php
/**
 * DefaultSkin.php
 *
 * PHP version 7
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Number
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\RatingStar;

use XeFrontend;
use Xpressengine\DynamicField\AbstractSkin;

/**
 * Class DefaultSkin
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Number
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RatingStar extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Number/fieldSkin/dynamic_field_extend@RatingStar';
    protected static $loaded = false;

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Rating Star Full';
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
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.RatingStar.full';
    }


    protected function appendScript()
    {
        XeFrontend::css(
            asset('plugins/dynamic_field_extend/assets/star.css')
        )->load();
    }

    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        if (self::$loaded === false) {

            $this->appendScript();
            self::$loaded = true;
        }
        return parent::create($args);
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
        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

        return parent::edit($args);
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
        $this->appendScript();
        return parent::output($name,$args);
    }
}
