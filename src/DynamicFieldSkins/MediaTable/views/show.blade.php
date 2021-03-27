<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    {{--<div>--}}
    {{--<button type="button" class="xe-btn" onclick=media_popup("{{$config->get('id')}}")><i class="xi-plus"></i> 미디어 라이브러리</button>--}}
    {{--</div>--}}
    <div class="thumb_{{$config->get('id')}}">
        @if($media)
            @foreach($media as $data)
                {{--{{var_dump(XeStorage::find($data))}}--}}
                @if(XeStorage::find($data))
                    <div class="media">
                        <img src="{{$storage_path.'/'.XeStorage::find($data)->path.'/'.XeStorage::find($data)->filename}}">
                    </div>
                @endif
            @endforeach
        @endif

    </div>
</div>
{{--<input type="hidden" name="{{$config->get('id').'_column'}}" id="{{$config->get('id').'_column'}}" value="{{$config->get('id')}}">--}}
