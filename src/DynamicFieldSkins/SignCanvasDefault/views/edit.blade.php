<style>
    canvas {
        border: 1px solid #000000;
        margin-bottom:10px;
    }
    .unchecked {
        color:#ff0000;
    }
    .checked {
        color:#0000ff;
    }
</style>
<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_textarea __xe_df_textarea_information">{{xe_trans($config->get('label'))}}</label>
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic"><small>서명 후 서명확정 버튼을 눌러주세요</small></label>
    <br />
    <input type="hidden" name="{{$config->get('id')}}_edit" value="N">
    <input type="hidden" name="{{$config->get('id')}}_text" value="{{$data['text']}}" required>
    @if($data['text'] !== '')
        <label id="{{$config->get('id')}}_check_label" class="checked">{{date('Y년 m월 d일 H시 i분', strtotime($data['signature_date']))}}  서명이 확인 되었습니다.</label>
    @else
        <label id="{{$config->get('id')}}_check_label" class="unchecked">등록된 서명이 없습니다.</label>
    @endif
    <br />
    <div id="{{$config->get('id')}}_sign_field">
        @if($data['text'] !== '')
            <img src="{{$data['text']}}" style="width:400px; height:200px;">
        @else
            <p>등록된 서명이 없습니다</p>
        @endif
    </div>
    <a class="btn btn-info btn-sm" data-toggle="modal" data-animation="bounce" data-target=".callOtherSequenceClipData" id="getClipDataOpenModal" data-backdrop="static" data-keyboard="false">서명하기</a>
</div>

<div class="modal fade callOtherSequenceClipData" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">서명</h5>
            </div>
            <div class="modal-body">
                <section class="signature-component">
                    <h3>서명을 해주세요</h3>
                    <div class="w-100 text-center py-2">
                        <canvas id="signature-pad" width="400" height="200"></canvas>
                    </div>

                    <div>
                        <button id="{{$config->get('id')}}_save" type="button" class="button">서명 확정</button>
                        <button id="{{$config->get('id')}}_clear" type="button" class="button">초기화</button>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <a class="btn xe-btn-secondary" data-dismiss="modal" id="{{$config->get('id')}}_closeModal">닫기</a>
            </div>
        </div>
    </div>
</div>

@include('dynamic_field_extend::src.DynamicFieldSkins.SignCanvasDefault.views.script')
