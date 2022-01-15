@php
$item = $data['text'] ?: app('xe.keygen')->generate();
@endphp
<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <div>
        <input type="hidden" name="{{$config->get('id')}}_text" value="{{$item}}" />
        {!! uio('langText', ['id' => $config->get('id'), 'langKey'=> $item, 'name'=> $config->get('id')]) !!}
    </div>
</div>
