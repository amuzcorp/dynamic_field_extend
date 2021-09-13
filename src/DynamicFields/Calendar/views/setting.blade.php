<div class="form-group">
    <label class="xe-form__label--requried">DatePicker 종류</label>
    <select name="picker_type" class="form-control">
        <option value="date" @if($config !== null && $config->get('picker_type') === 'date') selected="selected"@endif>일자만</option>
        <option value="date_time" @if($config !== null && $config->get('picker_type') === 'date_time') selected="selected"@endif>일자+시간</option>
    </select>
</div>

<div class="form-group">
    <label class="xe-form__label--requried">날짜 선택 형식</label>
    <select name="date_type" class="form-control">
        <option value="single" @if($config !== null && $config->get('date_type') === 'single') selected="selected"@endif>단일필드</option>
        <option value="multi" @if($config !== null && $config->get('date_type') === 'multi') selected="selected"@endif>시작일+종료일</option>
    </select>
</div>

<div class="form-group">
    <label class="xe-form__label--requried">시간 선택 형식</label>
    <select name="time_type" class="form-control">
        <option value="single" @if($config !== null && $config->get('time_type') === 'single') selected="selected"@endif>단일필드</option>
        <option value="multi" @if($config !== null && $config->get('time_type') === 'multi') selected="selected"@endif>시작시간+종료시간</option>
    </select>
</div>
