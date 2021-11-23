<style>
    .unchecked {
        color:#ff0000 !important;
    }
    .checked {
        color:#0000ff !important;
    }
    img {
        pointer-events: none;
    }
</style>
<div class="xe-form-group xe-dynamicField">
    <h3>{{xe_trans($config->get('label'))}}</h3>
    @if($data['text'] !== '')
        <label id="{{$config->get('id')}}_check_label" class="checked">서명이 확인 되었습니다.</label>
    @else
        <label id="{{$config->get('id')}}_check_label" class="unchecked">등록된 서명이 없습니다.</label>
    @endif
    <div id="{{$config->get('id')}}_sign_field">
        @if($data['text'] !== '')
            <img src="{{$data['text']}}" style="width:400px; height:200px;">
        @else
            <p>등록된 서명이 없습니다</p>
        @endif
    </div>
</div>
