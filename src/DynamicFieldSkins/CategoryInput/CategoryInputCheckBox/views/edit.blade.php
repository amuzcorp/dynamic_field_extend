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
    @if ($config->get('skinDescription') !== '')
        <small>{{$config->get('skinDescription')}}</small>@endif
    <input type="hidden" name="{{$config->get('id') . '_column[]'}}" value="">

    @if(gettype($data_array)=='array')
        <ul class="check_ul">
            @foreach ($cate as $item)
                <li class="check_box_input_li"><input type="checkbox" class="checkbox_category_input"
                                       name="{{$config->get('id') . '_column[]'}}"
                                       value="{{$item[0]}}" @if($data_array){{array_search($item['0'], $data_array) !== false ? 'checked="checked"' : ''}}@endif>{{$item[1]}}
                </li>

            @endforeach
        </ul>
    @elseif(gettype($data_array)=='string')
        <ul class="check_ul">
            @foreach ($cate as $item)
                <li class="check_box_input_li"><input type="checkbox" class="checkbox_category_input"
                                       name="{{$config->get('id') . '_column[]'}}"
                                       value="{{$item[0]}}" @if($data_array){{$item['0'] == $data_array ? 'checked="checked"' : ''}}@endif>{{$item[1]}}
                </li>

            @endforeach
        </ul>
    @endif
</div>