<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_text __xe_df_text_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if($config->get('date_type') == 'single')
        <div>
            <span>{{ $data['start'] }}</span>
        </div>
    @else
        <div>
            <span>{{ $data['start'] }}</span><span> ~ </span><span>{{ $data['end'] }}</span>
        </div>
    @endif
</div>
