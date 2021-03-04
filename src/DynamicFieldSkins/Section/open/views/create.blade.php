<section id="{{ $config->get('css_id') ? $config->get('css_id') : '' }}"
         class="{{ $config->get('css_class') ? $config->get('css_class') : '' }}"
         style="{{ $config->get('css_style') ? $config->get('css_style') : '' }}"
>
    <div class="panel">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">{{xe_trans($config->get('label'))}}</h3>
                <small>{{xe_trans($config->get('placeholder',''))}}</small>
            </div>
        </div>
        <div class="panel-body">
