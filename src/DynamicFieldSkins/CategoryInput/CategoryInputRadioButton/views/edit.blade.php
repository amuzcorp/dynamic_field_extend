<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif



        {{--@foreach ($cate as $item)--}}
            {{--<label class="xe-label">--}}
                {{--<input type="radio" name="{{$config->get('id') . '_column'}}" value="{{$item[0]}}" @if(json_encode(trim($item[0])) == trim($args[$config->get('id').'_column'])) {{"checked=checked"}} @endif>--}}
                {{--<span class="xe-input-helper"></span>--}}
                {{--<span class="xe-label-text">{{$item[1]}}</span>--}}
            {{--</label>--}}
        {{--@endforeach--}}

    @if(gettype(json_decode($args[$config->get('id').'_column'])) == "array")
        - 단일 선택 방식으로 변경됐습니다. 하나만 선택가능합니다.
        <label class="xe-label">
            <input type="radio" name="{{$config->get('id') . '_column'}}" value="">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text">{{xe_trans($config->get('label'))}}</span>
        </label>
        @foreach ($cate as $item)
            <label class="xe-label">
                <input type="radio" name="{{$config->get('id') . '_column'}}" value="{{$item[0]}}"@if(array_search($item[0], json_decode($args[$config->get('id').'_column'])) !== false) {{"checked=checked"}} @endif>
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{$item[1]}}</span>
            </label>
        @endforeach
    @elseif(gettype(json_decode($args[$config->get('id').'_column'])) == "string")
        <label class="xe-label">
            <input type="radio" name="{{$config->get('id') . '_column'}}" value="">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text">{{xe_trans($config->get('label'))}}</span>
        </label>
            @foreach ($cate as $item)
                <label class="xe-label">
                    <input type="radio" name="{{$config->get('id') . '_column'}}" value="{{$item[0]}}" @if(json_encode(trim($item[0])) == trim($args[$config->get('id').'_column'])) {{"checked=checked"}} @endif>
                    <span class="xe-input-helper"></span>
                    <span class="xe-label-text">{{$item[1]}}</span>
                </label>
            @endforeach
    @else
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
    @endif
</div>