{{-- @deprecated .form-control --}}
<fieldset class="dynamic_field_rate half">
    <input type="radio" id="__xe_df_number_{{$config->get('id')}}10" @if($data['num'] === 10) checked @endif name="{{$key['num']}}" value="10" /><label for="__xe_df_number_{{$config->get('id')}}10" title="5 stars"></label>
    <input type="radio" id="__xe_df_number_{{$config->get('id')}}8" @if($data['num'] === 8) checked @endif name="{{$key['num']}}" value="8" /><label for="__xe_df_number_{{$config->get('id')}}8" title="4 stars"></label>
    <input type="radio" id="__xe_df_number_{{$config->get('id')}}6" @if($data['num'] === 6) checked @endif name="{{$key['num']}}" value="6" /><label for="__xe_df_number_{{$config->get('id')}}6" title="3 stars"></label>
    <input type="radio" id="__xe_df_number_{{$config->get('id')}}4" @if($data['num'] === 4) checked @endif name="{{$key['num']}}" value="4" /><label for="__xe_df_number_{{$config->get('id')}}4" title="2 stars"></label>
    <input type="radio" id="__xe_df_number_{{$config->get('id')}}2" @if($data['num'] === 2) checked @endif name="{{$key['num']}}" value="2" /><label for="__xe_df_number_{{$config->get('id')}}2" title="1 star"></label>
</fieldset>
