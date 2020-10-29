다이나믹 플러그인 설정페이지
<div>
    <form method="post" action="{{route('manage.dynamic_field_extend.updateConfig')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
    해시태그 :
        <select name="hash_tag">
            <option value="0" @if($config->get('hash_tag') == 0) selected @endif>off</option>
            <option value="1" @if($config->get('hash_tag') == 1) selected @endif>on</option>
        </select>
        <br/>
        <label for="favcolor">색상선택:</label>
        <input type="color" id="favcolor" name="favcolor" value="#ff0000">
        <button type="submit">설정 변경</button>
        <a href="{{route('settings.extension.installed')}}">뒤로가기</a>
    </form>
</div>