<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    {{--<select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">--}}
        {{--<option value="">{{xe_trans($config->get('label'))}}</option>--}}
        {{--@foreach ($items as $item)--}}
            {{--<option value="{{$item->id}}">{{xe_trans($item->word)}}</option>--}}
        {{--@endforeach--}}
    {{--</select>--}}

    {{--{{var_dump(Request::get('category_item_id'))}}--}}
    {{--{{var_dump(count($categories))}}--}}

{{--    {{var_dump($categories[0]['children'][0]['children'])}}--}}


    <select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">
    <option value="">{{xe_trans($config->get('label'))}}</option>
        {{--{{$categories}}--}}
        @foreach($items as $item)
            <option value="{{$item[0]}}">{{xe_trans($item[1])}}</option>
        @endforeach
    </select>


    {{--{!! uio('uiobject/board@new_select', [--}}
    {{--'name' => 'category_item_id',--}}
    {{--'label' => xe_trans('xe::category'),--}}
    {{--'value' => Request::get('category_item_id'),--}}
    {{--'items' => $categories--}}
    {{--])--}}
    {{--!!}--}}

</div>
