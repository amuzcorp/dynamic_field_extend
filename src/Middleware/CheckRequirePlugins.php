<?php
namespace Amuz\XePlugin\DynamicFieldExtend\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Http\Request;


class CheckRequirePlugins
{
    protected $app;

    protected $gate;

    public function __construct(Application $app, GateContract $gate)
    {
        $this->app = $app;
        $this->gate = $gate;
    }

    public function handle(Request $request, Closure $next)
    {
        $plugin = 'dynamic_field_extend';
        // 필요한 플러그인이 활성화 되어있는지 검사한다.
        $pluginHandler = app('xe.plugin');
        $integrated_keychain = $pluginHandler->getPlugin('integrated_keychain');
        $need_plugins = false;
        $message = '';

        if (!$integrated_keychain || $integrated_keychain->getStatus() != 'activated') {
            $need_plugins = true;
            $message .= '통합 키체인 플러그인이 활성화 되어 있어야 합니다.';
        }

        if($need_plugins){
            $pluginHandler->deactivatePlugin($plugin);

            return redirect()->route('settings.extension.installed')->with(
                'alert',
                ['type' => 'failed', 'message' => $message]
            );
        }

        return $next($request);
    }
}
