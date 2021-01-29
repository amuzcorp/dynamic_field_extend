<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_text __xe_df_text_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if($config->get('date_type') == 'single')
        @if(count($values) > 0)
        <div>
            <span>{{ $values[0] }}</span>
        </div>
        @endif
    @else
        @if(count($values) > 1)
        <div>
            <span>{{ $values[0] }}</span><span> ~ </span><span>{{ $values[1] }}</span>
        </div>
        @endif
    @endif
</div>
