<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <input hidden name="{{$config->get('id') . '_item_id[]'}}">

    <ul>
        @if(gettype($itemId)=="array")

            @foreach ($items as $item)
                    <li>{{xe_trans($item['word'])}}<input type="checkbox" name="{{$config->get('id') . '_item_id[]'}}" value="{{$item['id']}}" @if($itemId){{array_search($item['id'], $itemId) !== false ? 'checked="checked"' : ''}}@endif></li>
            @endforeach

        @elseif(gettype($itemId)=="string")

            @foreach ($items as $item)
                    <li>{{xe_trans($item['word'])}}<input type="checkbox" name="{{$config->get('id') . '_item_id[]'}}" value="{{$item['id']}}" @if($itemId){{$item['id'] == $itemId ? 'checked="checked"' : ''}}@endif></li>
            @endforeach

        @endif
    </ul>
</div>
