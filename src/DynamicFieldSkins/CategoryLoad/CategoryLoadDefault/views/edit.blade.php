<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    {{--{{var_dump(gettype(json_decode($data['item_id'])))}}--}}

        @if(gettype(json_decode($data['item_id']))=="string")
        <select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
            <option value="">{{xe_trans($config->get('label'))}}</option>
            @foreach ($items as $item)
                {{--<option value="{{$item['id']}}" {{$itemId == $item['id'] ? 'selected="selected"' : ''}}>{{xe_trans($item['word'])}}</option>--}}
                <option value="{{$item[0]}}" {{$itemId == $item[0] ? 'selected="selected"' : ''}}>{{xe_trans($item[1])}}</option>
                {{--{{$item['id']}}--}}
            @endforeach
        </select>
        @elseif(gettype(json_decode($data['item_id']))=="array")
        - 단일 선택 방식으로 변경됐습니다. 하나만 선택가능합니다.
        <select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
            <option value="">{{xe_trans($config->get('label'))}}</option>
            @foreach ($items as $item)
                {{--<option value="{{$item['id']}}" {{ array_search($item['id'], json_decode($data['item_id'])) !== false ? 'selected="selected"' : ''}}>{{xe_trans($item['word'])}}</option>--}}
                <option value="{{$item[0]}}" {{ array_search($item[0], json_decode($data['item_id'])) !== false ? 'selected="selected"' : ''}}>{{xe_trans($item[1])}}</option>
                {{--{{$item['id']}}--}}
            @endforeach
        </select>
        @endif

</div>
