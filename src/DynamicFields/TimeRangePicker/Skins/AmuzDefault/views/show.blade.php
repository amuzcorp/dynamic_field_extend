<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_text __xe_df_text_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    <div>
        <span>{{ $data['start'] }}</span>@if($config->get('time_type') != 'single')<span> ~ </span><span>{{ $data['end'] }}</span>@endif
    </div>
</div>
