{{-- 해시태그 : <div>{{$args[$config->get('id').'_column']}}</div> --}}

{{--@if ($scriptInit) --}}
{{-- XeFrontend::js('plugins/board/assets/js/BoardTags.js')->appendTo('body')->load() --}}
{{--@endif--}}
@if($args['instance_id']!="xe_blog")
@if($config_dynamic->get('hash_tag') == 1)
<div class="xe-list-board-body__article-tag">
    <ul class="xe-list-board-body__article-tag-list">
        @foreach ($item as $tag)
            <li class="xe-list-board-body__article-tag-list-item"><a href="{{instance_route('index', ['searchTag' => $tag['word']], $args['instance_id'])}}" class="xe-list-board-body__link">{{ $tag['word'] }}</a></li>
        @endforeach
    </ul>
</div>
@endif
@endif