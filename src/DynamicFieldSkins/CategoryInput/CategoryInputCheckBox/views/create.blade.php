<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    {{--<select name="{{$config->get('id') . '_column[]'}}" class="xe-form-control" style="height: 150px" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>--}}
        {{--<option value="">{{xe_trans($config->get('label'))}}</option>--}}
        {{--@foreach ($cate as $item)--}}
            {{--<option value="{{$item[0]}}">{{$item[1]}}</option>--}}
        {{--@endforeach--}}
    {{--</select>--}}

    <ul>
        @foreach ($cate as $item)
            <li>{{$item[1]}}<input type="checkbox" name="{{$config->get('id') . '_column[]'}}" value="{{$item[0]}}"></li>
        @endforeach
    </ul>
</div>