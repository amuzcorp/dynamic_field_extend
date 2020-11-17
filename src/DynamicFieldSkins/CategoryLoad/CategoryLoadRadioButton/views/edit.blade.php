<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    @if(gettype(json_decode($data['item_id'])) == 'string')
        <label class="xe-label">
            <input type="radio" name="{{$config->get('id') . '_item_id'}}" value="">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text">{{xe_trans($config->get('label'))}}</span>
        </label>
        @foreach ($data['items'] as $item)
            <label class="xe-label">
                {{--<input type="radio" name="{{$config->get('id') . '_item_id'}}" value="{{$item['value']}}" @if (json_decode($data['item_id']) == $item['value']) checked @endif>--}}
                {{--<span class="xe-input-helper"></span>--}}
                {{--<span class="xe-label-text">{{xe_trans($item['text'])}}</span>--}}
                <input type="radio" name="{{$config->get('id') . '_item_id'}}" value="{{$item[0]}}" @if (json_decode($data['item_id']) == $item[0]) checked @endif>
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{xe_trans($item[1])}}</span>
            </label>
        @endforeach

    @elseif(gettype(json_decode($data['item_id'])) == 'array')
        - 단일 선택 방식으로 변경됐습니다. 하나만 선택가능합니다.
        <label class="xe-label">
            <input type="radio" name="{{$config->get('id') . '_item_id'}}" value="">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text">{{xe_trans($config->get('label'))}}</span>
        </label>
        @foreach ($data['items'] as $item)
            <label class="xe-label">
                {{--<input type="radio" name="{{$config->get('id') . '_item_id'}}" value="{{$item['value']}}" @if(array_search($item['value'], json_decode($data['item_id']))) checked @endif>--}}
                {{--<span class="xe-input-helper"></span>--}}
                {{--<span class="xe-label-text">{{xe_trans($item['text'])}}</span>--}}
                <input type="radio" name="{{$config->get('id') . '_item_id'}}" value="{{$item[0]}}" @if(array_search($item[0], json_decode($data['item_id']))) checked @endif>
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{xe_trans($item[1])}}</span>
            </label>
        @endforeach

    @endif
</div>
