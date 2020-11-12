<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <label class="xe-label">
        <input type="radio" name="{{$config->get('id') . '_column'}}" value="">
        <span class="xe-input-helper"></span>
        <span class="xe-label-text">{{xe_trans($config->get('label'))}}</span>
    </label>
        @foreach ($cate as $item)
            <label class="xe-label">
                <input type="radio" name="{{$config->get('id') . '_column'}}" value="{{$item[0]}}">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{$item[1]}}</span>
            </label>
        @endforeach
</div>