<style>
    .float-right {
        float: right;
    }
</style>
<div class="form-group">
    <label>{{ xe_trans($config->get('label')) }} 결과<small>{{ $config->get('id') }}</small></label>
    <div id="autocomplete_{{ $config->get('id') }}">
        <input type="hidden" name="{{$config->get('id')}}_doc_id" value="" />
        <input type="hidden" name="{{$config->get('id')}}_result" value="" />
        <div class="ReactTags__tags">
            <a class="badge" id="{{$config->get('label')}}_selected_document">선택된 {{ xe_trans($config->get('label')) }}(이)가 없습니다</a> <a class="float-right" onclick="viewDocumentListModal()">문서 선택하기</a>
        </div>
    </div>
</div>

<a style="display: none;" data-toggle="modal" data-animation="bounce" data-target=".viewDocumentList" id="viewDocumentList" data-backdrop="static" data-keyboard="false"></a>
<div class="modal fade viewDocumentList" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ xe_trans($config->get('label')) }} 리스트</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="{{$config->get('id')}}_page" value="1">
                <div class="">
                    <table class="table">
                        <colgroup>
                            <col style=""/>
                            <col style="width:20%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>{{ xe_trans($config->get('label')) }}명</th>
                            <th>선택</th>
                        </tr>
                        </thead>
                        <tbody id="{{$config->get('id')}}_form_list">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn xe-btn-secondary" data-dismiss="modal" id="{{$config->get('id')}}_closeModal">닫기</a>
            </div>
        </div>
    </div>
</div>

<div id="test">
    <table class="table text-center question_form">
        <thead>
        <tr>
            <th colspan="2" class="text-center">설문조서</th>
        </tr>
        </thead>
    </table>
    <div>
        <input type="hidden" name="{{$config->get('target_field_id')}}_columns_total_question" value="0">
        <div id="question_form"></div>
{{--        @foreach($question as $key => $val)--}}
{{--            <table class="table text-center question_form">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <td colspan="2">--}}
{{--                        <input type="text"--}}
{{--                               class="form-control"--}}
{{--                               value="{{$val->title}}"--}}
{{--                               readonly>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($val->questions as $question_key => $question_val)--}}
{{--                    <tr>--}}
{{--                        <td style="width:5%;">--}}
{{--                            <input type="radio"--}}
{{--                                   name="{{$question_field}}_question_{{$key+1}}_radio"--}}
{{--                                   @if($question_key === 0)--}}
{{--                                   checked=""--}}
{{--                                   @endif--}}
{{--                                   value="{{ $question_key + 1 }}" onchange="setQuestions( {{count($val->questions)}}, {{$key+1}}, {{$question_key + 1}}, this )">--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <input type="text" class="form-control mb-5px" value="{{$question_val->value}}" readonly>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @endforeach--}}
    </div>

</div>

@include('dynamic_field_extend::src.DynamicFields.Survey_results.Skins.Common.views.script')
