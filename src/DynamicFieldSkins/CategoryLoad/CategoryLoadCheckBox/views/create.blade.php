<style>
    .checkbox_category_input {
        display: inline-block;
        width: 18px;
        height: 18px;
        line-height: 18px;
        margin: -2px 8px 0 0;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #e0e0e0;
    }

    .check_ul {
        list-style:none;
    }

    .check_box_input_li{
        font-size: 14px;
        color: #484848;
        letter-spacing: -0.19px;
    }
</style>
<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    {{--<select name="{{$config->get('id') . '_item_id[]'}}" class="xe-form-control" style="height: 150px" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>--}}
    {{--<div>{{xe_trans($config->get('label'))}}</div>--}}
    <ul class="check_ul">
        @foreach ($items as $item)
            {{--<li>{{xe_trans($item->word)}}<input type="checkbox" name="{{$config->get('id') . '_item_id[]'}}" value="{{$item->id}}"></li>--}}
            <li class="check_box_input_li"><input type="checkbox" class="checkbox_category_input" name="{{$config->get('id') . '_item_id[]'}}" value="{{$item[0]}}">{{xe_trans($item[1])}}</li>
        @endforeach
    </ul>
    {{--</select>--}}
</div>
