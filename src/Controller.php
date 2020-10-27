<?php
namespace Amuz\XePlugin\DynamicFieldExtend;

use XeFrontend;
use XePresenter;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $title = 'DynamicFieldExtend plugin';

        // set browser title
        XeFrontend::title($title);

        // load css file
        XeFrontend::css(Plugin::asset('assets/style.css'))->load();

        // output
        return XePresenter::make('dynamic_field_extend::views.index', ['title' => $title]);
    }
}
