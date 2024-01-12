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
    <input type="hidden" name="{{$config->get('id')}}_columns" value="" >
    <input type="hidden" name="{{$config->get('id')}}_table_count" value="0">
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
