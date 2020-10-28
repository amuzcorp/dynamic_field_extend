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
        /*
        $configManager = app('xe.config');
        $config = $configManager->get('openseminar');
        if ($config === null) {
            $config = new ConfigEntity();

            $config->set('document_point', 2);
            $config->set('comment_point', 1);
            $configManager->add('openseminar', $config->getPureAll());
        }
*/
        return XePresenter::make('dynamic_field_extend::views.manager.index', []);
    }

    public function updateConfig(Request $request)
    {
        var_dump('index_test');exit;
        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configManager = app('xe.config');
        $configManager->put('openseminar', [
            'document_point' => $request->get('document_point'),
            'comment_point' => $request->get('comment_point'),
        ]);

        return Redirect::to(route('manage.openseminar_1212.index'));
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
