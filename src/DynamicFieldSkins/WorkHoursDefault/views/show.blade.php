{{--{{XeFrontend::js('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js')->appendTo('head')->load() }}--}}
{{XeFrontend::js('https://code.jquery.com/ui/1.12.1/jquery-ui.js')->appendTo('head')->load() }}
{{XeFrontend::css('http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css')->load()}}


<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $config->get('id') }}">{{ xe_trans($config->get('label')) }}</label>
    <input type="hidden" id="{{$config->get('id')}}_etc_schedule_data" name="{{$config->get('id')}}_etc_schedule_data"
           value="{{$data["etc_schedule_data"]}}">
    @if ($config->get('skinDescription') !== '')
        <small>{{ $config->get('skinDescription') }}</small>
    @endif


    <br><label>{{$now_str}}</label>
    <br><label>{{$today_str}}</label>
</div>


