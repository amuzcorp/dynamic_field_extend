<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <select name="{{$config->get('id') . '_column[]'}}" class="xe-form-control" style="height: 150px" data-valid-name="{{ xe_trans($config->get('label')) }}" multiple>
        @if($config->get('required') === false)
        <option value="">{{xe_trans($config->get('label'))}}</option>
        @endif
        @if(gettype($data_array)=='array')
                @foreach ($cate as $item)
                    <option value="{{$item[0]}}" @if($data_array) @if(array_search(trim($item[0]), $data_array) !== false) {{"selected=selected"}} @endif @endif>{{$item[1]}}</option>

                @endforeach
        @elseif(gettype($data_array)=='string')
                @foreach ($cate as $item)
                <option value="{{$item[0]}}" @if($data_array) @if($item[0] == $data_array) {{"selected=selected"}} @endif @endif>{{$item[1]}}</option>

                @endforeach
        @else
                @foreach ($cate as $item)
                    <option value="{{$item[0]}}">{{$item[1]}}</option>

                @endforeach
        @endif
    </select>
</div>