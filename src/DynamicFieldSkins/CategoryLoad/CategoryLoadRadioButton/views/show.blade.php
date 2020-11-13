{{--<div class="xe-form-group xe-dynamicField">--}}
    {{--<label class="__xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>--}}
    {{--{{xe_trans($data['selectedItemText'])}}--}}
{{--</div>--}}

<div class="xe-form-group xe-dynamicField">
    {{--{{var_dump( gettype(json_decode($data['categoryItem'] ))) }}--}}

    @if(gettype(json_decode($data['categoryItem'] )) == "object")
        @if($data['categoryItem'] != null && !empty($data['categoryItem']->word))
            <span>{{ xe_trans($data['categoryItem']->word) }}</span>
        @endif
    @elseif(gettype(json_decode($data['categoryItem'] )) == "array")
        @if($data['categoryItem'] != null)
            @foreach(json_decode($data['categoryItem']) as $cate_item)
                <span>- {{ xe_trans($cate_item->word) }}</span>
                {{--<span>{{$cate_item->word}}</span>--}}
            @endforeach
        @endif
    @endif
</div>
