<div class="form-group">
    <label class="xe-form__label--requried">날짜 선택 형식</label>
    <select name="date_type" class="form-control">
        <option value="single" @if($config !== null && $config->get('date_type') === 'single') selected="selected"@endif>단일필드</option>
        <option value="multi" @if($config !== null && $config->get('date_type') === 'multi') selected="selected"@endif>시작일+종료일</option>
    </select>
</div>
