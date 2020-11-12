@if ($config == null)
    @expose_route('fieldType.storeCategory')
    @expose_trans('xe::categoryManagement')
    {{ XeFrontend::js('/assets/core/common/js/storeCategory.js')->loadAsync() }}
@endif


<div class="form-group __xe_df_category">
    {{--<input type="hidden" name="category_id" id="my_cate_id" value="{{ $config != null ? $config->get('category_id') : '' }}" />--}}
    @if ($config == null)
        {{--<button type="button" id="btnCreateCategory">{{xe_trans('xe::createCategoryGroup')}}</button> : 버튼으로 카테고리를 생성 후 아래에서 사용할 카테고리 선택.--}}
    카테고리 선택 :
        <select class="form-control" name="category_load" id="select_cate_id">
            @foreach($category_all as $item)
                <option value="{{$item['id']}}">{{$item['id'].' : '.xe_trans($item['name'])}}</option>
            @endforeach
        </select>
    @else
        <div>원본 카테고리 정보 - 아이디 : {{$config->get('category_load')}}</div>
        {{--<a href="{{ route('manage.category.show', ['id' => $config->get('category_load')]) }}" target="_blank">{{xe_trans('xe::categoryManagement')}}</a>--}}
        <a href="{{ route('manage.category.show', ['id' => $config->get('category_load')]) }}" target="_blank">{{xe_trans('xe::categoryManagement')}}</a>
    @endif
</div>
<script>
    //alert(document.getElementById('my_cate_id').value);
    function change_cate_id(myid) {
        document.getElementById('my_cate_id').value = myid.value;
        //alert(document.getElementById('my_cate_id').value);
    }
</script>

