<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_number __xe_df_number_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <fieldset class="dynamic_field_rate half">
        <input type="radio" id="__xe_df_number_{{$config->get('id')}}10" @if(Request::old($key['num']) === 10) checked @endif name="{{$key['num']}}" value="10" /><label for="__xe_df_number_{{$config->get('id')}}10" title="5 stars"></label>
        <input type="radio" id="__xe_df_number_{{$config->get('id')}}8" @if(Request::old($key['num']) === 8) checked @endif name="{{$key['num']}}" value="8" /><label for="__xe_df_number_{{$config->get('id')}}8" title="4 stars"></label>
        <input type="radio" id="__xe_df_number_{{$config->get('id')}}6" @if(Request::old($key['num']) === 6) checked @endif name="{{$key['num']}}" value="6" /><label for="__xe_df_number_{{$config->get('id')}}6" title="3 stars"></label>
        <input type="radio" id="__xe_df_number_{{$config->get('id')}}4" @if(Request::old($key['num']) === 4) checked @endif name="{{$key['num']}}" value="4" /><label for="__xe_df_number_{{$config->get('id')}}4" title="2 stars"></label>
        <input type="radio" id="__xe_df_number_{{$config->get('id')}}2" @if(Request::old($key['num']) === 2) checked @endif name="{{$key['num']}}" value="2" /><label for="__xe_df_number_{{$config->get('id')}}2" title="1 star"></label>
    </fieldset>
</div>
