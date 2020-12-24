<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    @if(gettype(json_decode($args[$config->get('id').'_column'])) == "array")
        - 단일 선택 방식으로 변경됐습니다. 하나만 선택가능합니다.
        <select name="{{$config->get('id') . '_column'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
            <option value="">{{xe_trans($config->get('label'))}}</option>
            @foreach ($cate as $item)
                {{--<option value="{{$item[0]}}" @if(json_encode(trim($item[0])) == trim($args[$config->get('id').'_column'])) {{"selected=selected"}} @endif>{{$item[1]}}</option>--}}
                <option value="{{$item[0]}}" @if(array_search($item[0], json_decode($args[$config->get('id').'_column'])) !== false) {{"selected=selected"}} @endif>{{$item[1]}}</option>
            @endforeach
        </select>

    @elseif(gettype(json_decode($args[$config->get('id').'_column'])) == "string")

        <select name="{{$config->get('id') . '_column'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
            <option value="">{{xe_trans($config->get('label'))}}</option>
            @foreach ($cate as $item)
                <option value="{{$item[0]}}" @if(json_encode(trim($item[0])) == trim($args[$config->get('id').'_column'])) {{"selected=selected"}} @endif>{{$item[1]}}</option>
            @endforeach
        </select>

    @else
        <select name="{{$config->get('id') . '_column'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
            <option value="">{{xe_trans($config->get('label'))}}</option>
            @foreach ($cate as $item)
                <option value="{{$item[0]}}" >{{$item[1]}}</option>
            @endforeach
        </select>
    @endif
</div>