<div class="xe-form-group xe-dynamicField">
    {{--@if($data['categoryItem'] != null && !empty($data['categoryItem']->word))--}}
        {{--<span>{{ xe_trans($data['categoryItem']->word) }}</span>--}}
    {{--@endif--}}
        @if(isset($data['categoryItem']))
                @foreach($data['categoryItem'] as $item)
                <span>-{{ xe_trans($item->word) }}</span>
                {{--<span>{{ xe_trans($data['categoryItem']->word) }}</span>--}}
                @endforeach
        @endif
</div>
