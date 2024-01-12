@php

$question_data = [];
if($values[$config->get('id').'_columns'] !== '') {
    $question_data = json_dec($values[$config->get('id').'_columns']);
}

@endphp
<style>
    .text-white {
        color:#ffffff !important;
    }
    .mb-5px {
        margin-bottom: 5px;
    }
    .mb-10px {
        margin-bottom: 10px;
    }
    table.question_form {
        border-bottom: 2px solid #e5e5e5;
    }
</style>
<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id')}}_columns" value="{{$values[$config->get('id').'_columns']}}" >
    <input type="hidden" name="{{$config->get('id')}}_table_count" value="{{count($question_data)}}">
    <div>
        <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic mb-3"><h4>{{ xe_trans($config->get('label')) }}</h4></label>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="row mb-10px">
                                        <div class="col-lg-10"><label>질문에 대한 답변</label></div>
                                        <div class="col-lg-2 text-center"><a class="btn btn-info btn-sm" onclick="add_question_form()">폼추가</a></div>
                                    </div>
                                    <div id="{{$config->get('id')}}_question_list">

                                        @foreach($question_data as $key => $val)
                                            <table class="table w-100 text-center question_form" id="{{$key+1}}">
                                                <thead>
                                                <tr>
                                                    <th colspan="2" class="text-center">설문문항</th>
                                                    <th class="text-center" style="width:15%;">
                                                        <a class="btn btn-danger btn-sm text-white" onclick="remove_question_form({{$key+1}})">폼제거</a>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" name="{{$config->get('id')}}_question_type_{{$key+1}}" @if(!isset($val->question_type)) value="1" @else value="{{$val->question_type}}" @endif>
                                                    <th colspan="2" class="text-center" style="vertical-align: middle;"><div class="row"><div class="col-md-12"><label>설문타입</label></div></div></th>
                                                    <th class="text-center">
                                                        <div class="row">
                                                            <div class="col-md-6 pl-0">
                                                                <div class="form-check-inline">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="{{$config->get('id')}}_question_type_{{$key+1}}1"
                                                                               name="{{$config->get('id')}}_question_type_{{$key+1}}_radio"
                                                                               class="custom-control-input"
                                                                               value="1"
                                                                               @if(!isset($val->question_type) || $val->question_type === 1)
                                                                                    checked
                                                                               @endif
                                                                               onchange="changeQuestionType({{$key+1}}, '{{$config->get('id')}}_question_form_list_{{$key+1}}', 1)">
                                                                        <label class="custom-control-label" for="{{$config->get('id')}}_question_type_{{$key+1}}1">객관식</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 p-0">
                                                                <div class="form-check-inline">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="{{$config->get('id')}}_question_type_{{$key+1}}2"
                                                                               name="{{$config->get('id')}}_question_type_{{$key+1}}_radio"
                                                                               class="custom-control-input"
                                                                               value="2"
                                                                               @if(isset($val->question_type) && $val->question_type === 2)
                                                                                    checked
                                                                               @endif
                                                                               onchange="changeQuestionType({{$key+1}}, '{{$config->get('id')}}_question_form_list_{{$key+1}}', 2)">
                                                                        <label class="custom-control-label" for="{{$config->get('id')}}_question_type_{{$key+1}}2">주관식</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr id="{{$config->get('id')}}_question_form_list_{{$key+1}}_check_type">
                                                    @if(!isset($val->question_type) || $val->question_type === 1)
                                                        <input type="hidden" name="{{$config->get('id')}}_question_check_type_{{$key+1}}" @if(!isset($val->question_check_type)) value="1" @else value="{{$val->question_check_type}}" @endif>
                                                        <th colspan="2" class="text-center" style="vertical-align: middle;"><div class="row"><div class="col-md-12"><label>문항선택방식</label></div></div></th>
                                                        <th class="text-center">
                                                            <div class="row">
                                                                <div class="col-md-6 p-0">
                                                                    <div class="form-check-inline">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="{{$config->get('id')}}_question_check_type_{{$key+1}}1"
                                                                                   name="{{$config->get('id')}}_question_check_type_{{$key+1}}_radio"
                                                                                   class="custom-control-input"
                                                                                   value="1"
                                                                                   @if(!isset($val->question_check_type) || $val->question_check_type === 1) checked @endif
                                                                                   onchange="changeQuestionCheckType({{$key+1}}, '{{$config->get('id')}}_question_form_list_{{$key+1}}', 1)" >
                                                                            <label class="custom-control-label" for="{{$config->get('id')}}_question_check_type_{{$key+1}}1">단일</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 p-0">
                                                                    <div class="form-check-inline">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="{{$config->get('id')}}_question_check_type_{{$key+1}}2"
                                                                                   name="{{$config->get('id')}}_question_check_type_{{$key+1}}_radio"
                                                                                   class="custom-control-input"
                                                                                   value="2"
                                                                                   @if(isset($val->question_check_type) && $val->question_check_type === 2) checked @endif
                                                                                   onchange="changeQuestionCheckType({{$key+1}}, '{{$config->get('id')}}_question_form_list_{{$key+1}}', 2)">
                                                                            <label class="custom-control-label" for="{{$config->get('id')}}_question_check_type_{{$key+1}}2">중복</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="text"
                                                               class="form-control"
                                                               name="{{$config->get('id')}}_question_title_{{$key+1}}"
                                                               onkeyup="setQuestions()"
                                                               placeholder="문항의 질문을 입력해주세요"
                                                               value="{{$val->title}}">
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-info text-white" style="padding: 0 5px 0 5px;" onclick="add_question_field({{$key+1}})">+</a>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <tbody id="{{$config->get('id')}}_question_form_list_{{$key+1}}">
                                                @if(!isset($val->question_type) || $val->question_type === 1)
                                                    @foreach($val->questions as $question_key => $question_val)
                                                        <tr id="{{$config->get('id')}}_question_form_list_{{$key+1}}_{{$question_key+1}}">
                                                            <td style="width:5%;">
                                                                <input type="radio"
                                                                       name="{{$config->get('id')}}_question_{{$key+1}}_radio"
                                                                       id="{{$config->get('id')}}_question_{{$key+1}}_radio_{{$question_key+1}}" onchange="setQuestions()" @if($question_val->checked) checked="" @endif>
                                                            </td>
                                                            <td>
                                                                <input name="{{$config->get('id')}}_question_{{$key+1}}_text_{{$question_key+1}}" type="text" class="form-control mb-5px" value="{{$question_val->value}}"
                                                                       placeholder="답변을 입력해주세요" onkeyup="setQuestions()">
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-danger text-white" style="padding: 0 7px 0 7px;" onclick="removeQuestions( {{$key+1}}, {{$question_key+1}} )">-</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dynamic_field_extend::src.DynamicFields.Questionnaire.Skins.Common.views.script', $config)
