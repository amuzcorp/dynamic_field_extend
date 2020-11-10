다이나믹 플러그인 설정페이지
<div>
    <form method="post" action="{{route('manage.dynamic_field_extend.updateConfig')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        해시태그 :
        <select name="hash_tag">
            <option value="0" @if($config->get('hash_tag') == 0) selected @endif>off</option>
            <option value="1" @if($config->get('hash_tag') == 1) selected @endif>on</option>
        </select>
        <br>

        미디어 라이브러리
        <select name="media_library">
            <option value="0" @if($config->get('media_library') == 0) selected @endif>off</option>
            <option value="1" @if($config->get('media_library') == 1) selected @endif>on</option>
        </select>

        <br>
        색상선택
        <select name="color_picker">
            <option value="0" @if($config->get('color_picker') == 0) selected @endif>off</option>
            <option value="1" @if($config->get('color_picker') == 1) selected @endif>on</option>
        </select>

        <br>
        테이블에디터
        <select name="edittable">
            <option value="0" @if($config->get('edittable') == 0) selected @endif>off</option>
            <option value="1" @if($config->get('edittable') == 1) selected @endif>on</option>
        </select>

        <br>
        카테고리 불러오기
        <select name="category_load">
            <option value="0" @if($config->get('category_load') == 0) selected @endif>off</option>
            <option value="1" @if($config->get('category_load') == 1) selected @endif>on</option>
        </select>

        <br><br>
        {{--<label for="favcolor">색상선택:</label>--}}
        {{--<input type="color" id="favcolor" name="favcolor" value="#ff0000">--}}
        <button type="submit">설정 변경</button>
        <a href="{{route('settings.extension.installed')}}">뒤로가기</a>
    </form>
</div>