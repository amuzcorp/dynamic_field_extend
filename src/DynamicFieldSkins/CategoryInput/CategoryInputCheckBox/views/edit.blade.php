<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <input hidden name="{{$config->get('id') . '_column[]'}}">
    <ul>
        @foreach ($cate as $item)
            {{--<option value="{{$item['id']}}" {{$itemId == $item['id'] ? 'selected="selected"' : ''}}>{{xe_trans($item['word'])}}</option>--}}
            {{--<option value="{{$item['id']}}" @if($itemId){{array_search($item['id'], $itemId) !== false ? 'selected="selected"' : ''}}@endif>{{xe_trans($item['word'])}}</option>--}}
            <li>{{$item[1]}}<input type="checkbox" name="{{$config->get('id') . '_column[]'}}" value="{{$item[0]}}" @if($data_array){{array_search($item['0'], $data_array) !== false ? 'checked="checked"' : ''}}@endif></li>
            {{--{{$item['id']}}--}}
        @endforeach
    </ul>
</div>