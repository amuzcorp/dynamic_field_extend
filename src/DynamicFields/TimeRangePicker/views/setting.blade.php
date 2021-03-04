<div class="form-group">
    <label class="xe-form__label--requried">시간 선택 형식</label>
    <select name="time_type" class="form-control">
        <option value="single" @if($config !== null && $config->get('time_type') === 'single') selected="selected"@endif>단일필드</option>
        <option value="multi" @if($config !== null && $config->get('time_type') === 'multi') selected="selected"@endif>시작시간+종료시간</option>
    </select>
</div>
