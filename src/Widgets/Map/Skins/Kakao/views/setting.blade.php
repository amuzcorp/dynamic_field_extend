<div class="form-group">
    <label>Kakao API Key</label>
    <input type="text" name="api_key" class="form-control" value="{{array_get($args, 'api_key')}}" />
</div>
<div class="form-group">
    <label>주소</label>
    <input type="text" name="address" class="form-control" value="{{array_get($args, 'address')}}" />
</div>
<div class="form-group">
    <label>지도 높이</label>
    <input type="text" name="height" class="form-control" value="{{array_get($args, 'height')}}" /> px (기본:350px)
</div>
