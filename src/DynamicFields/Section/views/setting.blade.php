<div class="form-group">
    <label for="">CSS ID</label>
    <small>CSS ID 셀렉터를 지정할 수 있습니다.</small>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">#</span>
        <input type="text" name="css_id" class="form-control" value="{{$config->get('css_id')}}">
    </div>
</div>

<div class="form-group">
    <label for="">CSS CLASS</label>
    <small>CSS ID 셀렉터를 지정할 수 있습니다. 여러개의 클래스는 띄워쓰기로 구분합니다.</small>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">.</span>
        <input type="text" name="css_class" class="form-control" value="{{$config->get('css_class')}}">
    </div>
</div>

<div class="form-group">
    <label for="" class="xe-form__label--requried">직접 스타일링</label>
    <small>직접 스타일링할 수 있습니다. css의 구문을 그대로 적용해야합니다.</small>
    <textarea name="css_style" class="form-control">{{$config->get('css_style')}}</textarea>
</div>

<h5 style="color:red;">새로운 섹션을 시작하면, 반드시 섹션 닫기를 추가해야 합니다.</h5>
