<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    {{--<select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>--}}
    {{--<select name="{{$config->get('id') . '_item_id[]'}}" class="xe-form-control" style="height: 150px" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>--}}
        {{--<div>{{xe_trans($config->get('label'))}}</div>--}}
    <input hidden name="{{$config->get('id') . '_item_id[]'}}">
    <ul>
        @foreach ($items as $item)
            {{--<option value="{{$item['id']}}" {{$itemId == $item['id'] ? 'selected="selected"' : ''}}>{{xe_trans($item['word'])}}</option>--}}
            {{--<option value="{{$item['id']}}" @if($itemId){{array_search($item['id'], $itemId) !== false ? 'selected="selected"' : ''}}@endif>{{xe_trans($item['word'])}}</option>--}}
            <li>{{xe_trans($item['word'])}}<input type="checkbox" name="{{$config->get('id') . '_item_id[]'}}" value="{{$item['id']}}" @if($itemId){{array_search($item['id'], $itemId) !== false ? 'checked="checked"' : ''}}@endif></li>
            {{--{{$item['id']}}--}}
        @endforeach
    </ul>
    {{--</select>--}}
</div>
