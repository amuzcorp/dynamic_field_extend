<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_address __xe_df_address_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    <span>
        {{ $data['doro'] }} (지번 주소 : {{ $data['jibun'] }})
        {{ $data['detail'] }}
    </span>
</div>
