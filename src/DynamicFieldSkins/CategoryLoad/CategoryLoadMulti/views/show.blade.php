<div class="xe-form-group xe-dynamicField">
    {{--@if($data['categoryItem'] != null && !empty($data['categoryItem']->word))--}}
        {{--<span>{{ xe_trans($data['categoryItem']->word) }}</span>--}}
    {{--@endif--}}

    {{--{{var_dump($data['categoryItem'])}}--}}

    @if(gettype(json_decode($data['categoryItem'])) == "array")
        @if(isset($data['categoryItem']))
                @foreach($data['categoryItem'] as $item)
                <span>- {{ xe_trans($item->word) }}</span>
                {{--<span>{{ xe_trans($data['categoryItem']->word) }}</span>--}}
                @endforeach
        @endif

    @elseif(gettype(json_decode($data['categoryItem'])) == "object")
        @if(isset($data['categoryItem']))
            <span>- {{ xe_trans($data['categoryItem']->word) }}</span>
        @endif
    @endif
</div>
