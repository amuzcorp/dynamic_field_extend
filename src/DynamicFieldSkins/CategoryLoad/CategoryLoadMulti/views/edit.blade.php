<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')
        <small>{{$config->get('skinDescription')}}</small>@endif
    {{--<select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>--}}

    <select name="{{$config->get('id') . '_item_id[]'}}" class="xe-form-control" style="height: 150px"
            data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>
        @if($config->get('required') === false)
            <option value="">{{xe_trans($config->get('label'))}}</option>
        @endif
        @if(gettype($itemId)=="array")

            @foreach ($items as $item)
                {{--<option value="{{$item['id']}}" @if($itemId){{array_search($item['id'], $itemId) !== false ? 'selected="selected"' : ''}}@endif>{{xe_trans($item['word'])}}</option>--}}
                <option value="{{$item[0]}}" @if($itemId){{array_search($item[0], $itemId) !== false ? 'selected="selected"' : ''}}@endif>{{xe_trans($item[1])}}</option>
            @endforeach

        @elseif(gettype($itemId)=="string")

            @foreach ($items as $item)
                {{--<option value="{{$item['id']}}" @if($itemId){{$item['id'] == $itemId ? 'selected="selected"' : ''}}@endif>{{xe_trans($item['word'])}}</option>--}}
                <option value="{{$item[0]}}" @if($itemId){{$item[0] == $itemId ? 'selected="selected"' : ''}}@endif>{{xe_trans($item[1])}}</option>
            @endforeach

        @else
            @foreach ($items as $item)
                {{--<option value="{{$item['id']}}" @if($itemId){{$item['id'] == $itemId ? 'selected="selected"' : ''}}@endif>{{xe_trans($item['word'])}}</option>--}}
                <option value="{{$item[0]}}">{{xe_trans($item[1])}}</option>
            @endforeach
        @endif
    </select>
</div>
