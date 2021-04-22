<div class="form-group">
    <label for="">평점을 계산할 대상</label>
    <small>Number필드로 생성된 다이나믹필드 하나를 지정하면, 해당필드id를 가진 레코드의 평점을 계산해줍니다.</small>
    <select class="form-control">
        @foreach($field_list as $field)
        <option value="{{ $field }}">{{ $field }}</option>
        @endforeach
    </select>
</div>
