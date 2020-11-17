<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <select name="{{$config->get('id') . '_item_id[]'}}" class="xe-form-control" style="height: 150px" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>
        <option value="">{{xe_trans($config->get('label'))}}</option>
        @foreach ($items as $item)
            {{--<option value="{{$item->id}}">{{xe_trans($item->word)}}</option>--}}
            <option value="{{$item[0]}}">{{xe_trans($item[1])}}</option>
        @endforeach
    </select>
</div>
