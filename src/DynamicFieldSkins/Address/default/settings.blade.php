<div class="form-group">
    <input type="text" name="skinDescription" placeholder="skin description" class="form-control" value="{{$config != null ? $config->get('skinDescription') : ''}}" />
</div>
<label>
    도로명 검색 API Key 를 발급 받아주세요
</label>
<br>
<small class="text-danger">
    API 종류 - 도로명주소 API<br/>
    API 유형 - 검색 API
</small>
<br />
<a href="https://www.juso.go.kr/addrlink/devAddrLinkRequestWrite.do?returnFn=write&cntcMenu=URL">https:://www.juso.go.kr</a>
<br />
<div class="form-group">
    <input type="text" name="apiKey" placeholder="API Key" class="form-control" value="{{$config != null ? $config->get('apiKey') : ''}}" />
</div>
