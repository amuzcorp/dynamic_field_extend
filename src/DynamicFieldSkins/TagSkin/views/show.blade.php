{{-- 해시태그 : <div>{{$args[$config->get('id').'_column']}}</div> --}}

{{--@if ($scriptInit) --}}
{{-- XeFrontend::js('plugins/board/assets/js/BoardTags.js')->appendTo('body')->load() --}}
{{--@endif--}}
@if(isset($args['instance_id']))
@if($args['instance_id']!="xe_blog")
@if($config_dynamic->get('hash_tag') == 1)
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
<div class="xe-list-board-body__article-tag">
    <ul class="xe-list-board-body__article-tag-list">
        @foreach ($item as $tag)
            <li class="xe-list-board-body__article-tag-list-item"><a href="{{instance_route('index', ['searchTag' => $tag['word']], $args['instance_id'])}}" class="xe-list-board-body__link">{{ $tag['word'] }}</a></li>
        @endforeach
    </ul>
</div>
@endif
@endif
    @endif