<style>
    .float-right {
        float: right;
    }
</style>
<div class="form-group">
    <label>{{ xe_trans($config->get('label')) }} 결과<small>{{ $config->get('id') }}</small></label>
    <div id="autocomplete_{{ $config->get('id') }}">
        <input type="hidden" name="{{$config->get('id')}}_doc_id" value="{{$data['doc_id']}}" />
        <input type="hidden" name="{{$config->get('id')}}_result" value="{{$data['result']}}" />
        <div class="ReactTags__tags">
            @if($documentData)
                <a class="badge" id="{{$config->get('label')}}_selected_document">{{$documentData->title}}</a> <a class="float-right" onclick="viewDocumentListModal()">문서 선택하기</a>
            @else
                <a class="badge" id="{{$config->get('label')}}_selected_document">선택된 {{ xe_trans($config->get('label')) }}(이)가 없습니다</a> <a class="float-right" onclick="viewDocumentListModal()">문서 선택하기</a>
            @endif
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
            <th colspan="2" class="text-center">설문조사</th>
        </tr>
        </thead>
    </table>
    <div>
        <input type="hidden" name="{{$config->get('id')}}_columns_total_question" @if($question !== '') value="{{count(json_dec($question))}}" @else value="0" @endif>
        <div id="question_form">
            @if($question !== '')
                @foreach(json_dec($question) as $key => $val)

                    <table class="table text-center question_form">
                        <thead>
                        <tr>
                            <td colspan="2">
                                <input type="text"
                                       class="form-control"
                                       value="Q : {{$val->title}}"
                                       readonly>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($val->question_type === 1)
                            @foreach($val->questions as $question_key => $question_val)
                                <tr>
                                    <td style="width:5%;">
                                        @if($val->question_check_type === 1)
                                            <input type="radio"
                                                   name="{{$config->get('id')}}_columns_question_{{$key+1}}_radio"
                                                   @if(json_dec($data['result'])->result[$key]->selected === ($question_key + 1))
                                                   checked=""
                                                   @endif
                                                   value="{{ $question_key + 1 }}" onchange="setQuestions('', {{$key+1}}, {{$question_key + 1}}, this )">
                                        @else
                                            <input type="checkbox"
                                                   id="customCheck{{$key+1}}_{{$question_key + 1}}"
                                                   name="{{$config->get('id')}}_columns_question_{{$key+1}}_radio"
                                                   @if( isset(json_dec($data['result'])->result[$key]->checked[$question_key]) && json_dec($data['result'])->result[$key]->checked[$question_key])
                                                   checked=""
                                                   @endif
                                                   data-parsley-multiple="groups"
                                                   data-parsley-mincheck="1"
                                                   value="{{ $question_key + 1 }}"
                                                   onchange="setQuestions('', {{$key+1}}, {{$question_key + 1}}, this )">
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" class="form-control mb-5px" value="{{$question_val->value}}" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">
                                    <textarea class="form-control"
                                              onchange="setQuestions( '', {{$key+1}}, {{$key + 1}}, this)">{{json_dec($data['result'])->result[$key]->text}}</textarea>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>
</div>

@include('dynamic_field_extend::src.DynamicFields.Survey_results.Skins.Common.views.script')
