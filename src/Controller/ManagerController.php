<?php
//namespace Akasima\OpenSeminar\Controller;
namespace Amuz\XePlugin\DynamicFieldExtend\Controller;

//use Akasima\openseminar_1212\Model\PointLog;
//use Amuz\XePlugin\DynamicFieldExtend\PointLog;
use App\Http\Controllers\Controller;
use XePresenter;
use Redirect;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;

class ManagerController extends Controller
{

    public function index()
    {
        //var_dump('index_test');exit;
        /** @var \Xpressengine\Config\ConfigManager $configManager */

        $configManager = app('xe.config');
        $config = $configManager->get('dynamic_field_extend');

        if ($config === null) {
            $config = new ConfigEntity();

            $config->set('hash_tag', 1);
            $config->set('media_library', 1);
            $config->set('color_picker', 1);
            $config->set('edittable', 1);
            $config->set('category_load', 1);
            $configManager->add('dynamic_field_extend', $config->getPureAll());
        }

        return XePresenter::make('dynamic_field_extend::views.manager.index', ['config'=>$config, ]);
    }

    public function updateConfig(Request $request)
    {
        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configManager = app('xe.config');
        $configManager->put('dynamic_field_extend', [
            'hash_tag' => $request->get('hash_tag'),
            'media_library' => $request->get('media_library'),
            'color_picker' => $request->get('color_picker'),
            'edittable' => $request->get('edittable'),
            'category_load' => $request->get('category_load')
        ]);
        return Redirect::to(route('manage.dynamic_field_extend.index'));
    }
/*
    public function pointLog()
    {
        $list = PointLog::orderBy('createdAt', 'desc')->get();

        return XePresenter::make('openseminar_1212::views.manager.pointLog', [
            'list' => $list
        ]);
    }
*/
}
