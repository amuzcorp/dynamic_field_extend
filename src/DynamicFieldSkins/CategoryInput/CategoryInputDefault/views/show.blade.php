<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    {{--<select name="{{$config->get('id') . '_column'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">--}}
        {{--<option value="">{{xe_trans($config->get('label'))}}</option>--}}
    {{--{{var_dump(json_decode($args[$config->get('id').'_column']))}}--}}

    @if(gettype(json_decode($args[$config->get('id').'_column'])) == "array")
        @foreach ($cate as $item)
            {{--<option value="{{$item[0]}}">{{$item[1]}}</option>--}}
            @if(array_search($item[0], json_decode($args[$config->get('id').'_column'])) !== false)
                <span>- {{$item[1]}}</span>
            @endif
        @endforeach
    @elseif(gettype(json_decode($args[$config->get('id').'_column'])) == "string")
        @foreach ($cate as $item)
            {{--<option value="{{$item[0]}}">{{$item[1]}}</option>--}}
            @if(json_encode(trim($item[0])) == trim($args[$config->get('id').'_column']))
                <span>- {{$item[1]}}</span>
            @endif
        @endforeach
    @endif
    {{--</select>--}}
</div>