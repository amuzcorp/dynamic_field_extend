<div class="form-group">
    <label class="">비메오 유저 아이디 (숫자)</label>
    <input type="text" placeholder="비메오 유저 ID(숫자)를 입력해주세요" class="form-control" name="user_id" value="{{$config->get('user_id')}}">
    <p class="help-block"></p>
    <label class="">클라이언트 Key</label>
    <input type="text" placeholder="비메오 클라이언트키를 발급 받아주세요" class="form-control" name="client_key" value="{{$config->get('client_key')}}">
    <p class="help-block"></p>
    <label class="">클라이언트 Secret Key</label>
    <input type="text" placeholder="비메오 클라이언트키를 발급 받아주세요" class="form-control" name="secret_key" value="{{$config->get('secret_key')}}">
    <p class="help-block"></p>
    <label class="">클라이언트 Access Token</label>
    <input type="text" placeholder="비메오 엑세스 토큰을 발급 받아주세요" class="form-control" name="access_token" value="{{$config->get('access_token')}}">
    <p class="help-block"></p>
</div>
