<style>
    .media-library-layer-popup {
        z-index: 9999 !important;
    }
</style>
<div class="form-group">
    <label>HTML 코드 입력</label>
    {!! editor($cpt_id, [
       'content' => Request::old('content', $config != null ? $config->get('content') : ''),
       'cover' => false,
       $config->name
    ]) !!}
</div>
