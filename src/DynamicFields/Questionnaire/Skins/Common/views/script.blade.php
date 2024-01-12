<style>
    .mb-0 {
        margin-bottom: 0 !important;
    }
    .p-0 {
        padding: 0 !important;
    }
    .pl-0 {
        padding: 0 !important;
    }
    .pr-0 {
        padding: 0 !important;
    }
</style>
<script>
    $(document).ready( function () {
        setQuestions();
    });
    function changeQuestionType(question_id, id, type) {
        var config_id = "{{$config->get('id')}}";
        var inputId = config_id + '_question_type_' + question_id;
        $('input[name='+inputId+']').val(type);
        var checkTypeId = id + '_check_type';
        if(type === 1) {
            var str = `<input type="hidden" name="${config_id}_question_check_type_${question_id}" value="1">
                    <th colspan="2" class="text-center" style="vertical-align: middle;"><div class="row"><div class="col-md-12"><label>문항선택방식</label></div></div></th>
                    <th class="text-center">
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                           <input type="radio" id="${config_id}_question_check_type_${question_id}1"
                                                  name="${config_id}_question_check_type_${question_id}_radio"
                                                  class="custom-control-input" checked
                                                  onchange="changeQuestionCheckType(${question_id}, '${id}', 1)" >
                                        <label class="custom-control-label" for="${config_id}_question_check_type_${question_id}1">단일</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-0">
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="${config_id}_question_check_type_${question_id}2"
                                               name="${config_id}_question_check_type_${question_id}_radio"
                                               class="custom-control-input"
                                               onchange="changeQuestionCheckType(${question_id}, '${id}', 2)">
                                        <label class="custom-control-label" for="${config_id}_question_check_type_${question_id}2">중복</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>`;
            document.getElementById(checkTypeId).innerHTML = str;
            add_question_field(question_id);
        } else {
            var formList = config_id + '_question_form_list_' + question_id;
            $('#'+checkTypeId).empty();
            $('#'+formList).empty();
        }

        setQuestions();
    }
    function changeQuestionCheckType(question_id, id, type) {
        var config_id = "{{$config->get('id')}}";
        var inputId = config_id + '_question_check_type_' + question_id;
        $('input[name='+inputId+']').val(type);

        setQuestions();
    }

    function add_question_form() {

        var question_list_id = "{{$config->get('id')}}_question_list";
        var question_table_id = (+$('input[name={{$config->get('id')}}_table_count]').val()) + 1;
        var form_list_id = "{{$config->get('id')}}_question_form_list_" + question_table_id;
        var config_id = "{{$config->get('id')}}";

        var str = `
            <table class="table w-100 text-center question_form" id="${question_table_id}">
                <thead>
                <tr>
                    <th colspan="2" class="text-center">설문문항</th>
                    <th class="text-center" style="width:15%;">
                        <a class="btn btn-danger btn-sm text-white" onclick="remove_question_form(${question_table_id})">폼제거</a>
                    </th>
                </tr>
                <tr>
                    <input type="hidden" name="${config_id}_question_type_${question_table_id}" value="1">
                    <th colspan="2" class="text-center" style="vertical-align: middle;"><div class="row"><div class="col-md-12"><label>설문타입</label></div></div></th>
                    <th class="text-center">
                        <div class="row">
                            <div class="col-md-6 pl-0">
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="${config_id}_question_type_${question_table_id}1" name="${config_id}_question_type_${question_table_id}_radio" class="custom-control-input" checked onchange="changeQuestionType(${question_table_id}, '${form_list_id}', 1)">
                                        <label class="custom-control-label" for="${config_id}_question_type_${question_table_id}1">객관식</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-0">
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="${config_id}_question_type_${question_table_id}2" name="${config_id}_question_type_${question_table_id}_radio" class="custom-control-input" onchange="changeQuestionType(${question_table_id}, '${form_list_id}', 2)">
                                        <label class="custom-control-label" for="${config_id}_question_type_${question_table_id}2">주관식</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr id="${form_list_id}_check_type">
                    <input type="hidden" name="${config_id}_question_check_type_${question_table_id}" value="1">
                    <th colspan="2" class="text-center" style="vertical-align: middle;"><div class="row"><div class="col-md-12"><label>문항선택방식</label></div></div></th>
                    <th class="text-center">
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                           <input type="radio" id="${config_id}_question_check_type_${question_table_id}1"
                                                  name="${config_id}_question_check_type_${question_table_id}_radio"
                                                  class="custom-control-input" checked
                                                  onchange="changeQuestionCheckType(${question_table_id}, '${form_list_id}', 1)" >
                                        <label class="custom-control-label" for="${config_id}_question_check_type_${question_table_id}1">단일</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 p-0">
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="${config_id}_question_check_type_${question_table_id}2"
                                               name="${config_id}_question_check_type_${question_table_id}_radio"
                                               class="custom-control-input"
                                               onchange="changeQuestionCheckType(${question_table_id}, '${form_list_id}', 2)">
                                        <label class="custom-control-label" for="${config_id}_question_check_type_${question_table_id}2">중복</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" class="form-control" name="${config_id}_question_title_${question_table_id}" onkeyup="setQuestions()" placeholder="문항의 질문을 입력해주세요" value="">
                    </td>
                    <td class="text-center">
                        <a class="btn btn-info text-white" style="padding: 0 5px 0 5px;" onclick="add_question_field(${question_table_id})">+</a>
                    </td>
                </tr>
                </thead>
                <tbody id="${form_list_id}">
                <tr id="${form_list_id}_1">
                    <td style="width:5%;">
                        <input type="radio" name="${config_id}_question_${question_table_id}_radio" id="${config_id}_question_${question_table_id}_radio_1" onchange="setQuestions()">
                    </td>
                    <td>
                        <input name="${config_id}_question_${question_table_id}_text_1" type="text" class="form-control mb-5px" value=""
                        placeholder="답변을 입력해주세요" onkeyup="setQuestions()">
                    </td>
                    <td class="text-center">
                        <a class="btn btn-danger text-white" style="padding: 0 7px 0 7px;" onclick="removeQuestions(${question_table_id},1)">-</a>
                    </td>
                </tr>
                </tbody>
            </table>
        `;
        $('input[name={{$config->get('id')}}_table_count]').val(question_table_id);
        $('#'+question_list_id).append(str);
    }

    function remove_question_form(id) {
        $('#'+id).remove();
        var config_id = "{{$config->get('id')}}";
        var question_list_id = config_id + "_question_list";
        var question_table = document.getElementById(question_list_id).getElementsByTagName('table');

        //<span id="${config_id}_${question_table_id}_label"
        for(let i = 0; i < question_table.length; i++) {
            // reflesh_form_id((i+1));
        }
    }

    function add_question_field(id) {
        var form_list_id = "{{$config->get('id')}}_question_form_list_" + id;

        var qeustion_type = $('input[name={{$config->get('id')}}_question_type_'+id+'_radio]:checked').val();

        if(+qeustion_type === 2) return false;

        var config_id = "{{$config->get('id')}}";

        var new_list_id = document.getElementById(form_list_id).getElementsByTagName('tr').length + 1;
        var new_question_id = document.getElementById(form_list_id).getElementsByTagName('input').length + 1;

        var str = `
        <tr id="${form_list_id}_${new_list_id}">
            <td style="width:5%;">
                <input type="radio" name="${config_id}_question_${id}_radio" id="${config_id}_question_${id}_radio_${new_list_id}" onchange="setQuestions()">
            </td>
            <td>
                <input name="${config_id}_question_${id}_text_${new_list_id}" type="text" class="form-control mb-5px" value=""
                placeholder="답변을 입력해주세요" onkeyup="setQuestions()">
            </td>
            <td class="text-center">
                <a class="btn btn-danger text-white" style="padding: 0 7px 0 7px;" onclick="removeQuestions(${id},${new_list_id})">-</a>
            </td>
        </tr>
        `;

        $('#' + form_list_id).append(str);
    }

    function setQuestions() {
        var question_list_id = "{{$config->get('id')}}_question_list";
        var question_table = document.getElementById(question_list_id).getElementsByTagName('table');
        var config = "{{$config->get('id')}}";
        var title_id = '';
        var title = '';
        var tbody_id = '';
        var tbody_tr = '';

        var values = [];

        var question_columns = [];
        var text = '';
        var value = '';

        var checked = false;
        for(let i = 0; i < question_table.length; i++) {
            title_id = config + '_question_title_' + question_table[i].id;
            title = $('input[name='+title_id+']').val();

            tbody_id = config + '_question_form_list_' + question_table[i].id;

            tbody_tr = document.getElementById(tbody_id).getElementsByTagName('tr');
            values = [];

            var type = +$('input[name='+ config + '_question_type_' + question_table[i].id + ']').val();
            var checkType = 0;

            if(type === 1) {
                checkType = +$('input[name='+config + '_question_check_type_' + question_table[i].id+']').val();
                for(let j = 0; j < tbody_tr.length; j++) {
                    text = $('input[name=' + config + '_question_' + question_table[i].id + '_text_' + (j + 1)).val();
                    checked = false;

                    if(document.getElementById( config + '_question_' + question_table[i].id + '_radio_' + (j + 1) ).checked) {
                        checked = true;
                    }
                    if(text !== '' && text !== undefined) {
                        value = $('input[name=' + config + '_question_' + question_table[i].id + '_text_' + (j + 1)).val();
                    } else {
                        value = '';
                    }
                    values.push(
                        { checked: checked, value: value }
                    );
                }
            } else {
                values = '';
            }

            question_columns.push(
                {'question_type': type, 'question_check_type': checkType, 'title': title, 'questions': values}
            );
        }

        if(question_columns.length === 0) {
            $("input[name={{$config->get('id')}}_columns]").val('');
        } else {
            $("input[name={{$config->get('id')}}_columns]").val(JSON.stringify(question_columns));
        }
    }

    function removeQuestions(id, question_id) {
        //tbody 아이디
        var form_list_id = "{{$config->get('id')}}_question_form_list_" + id;

        //tr 아이디
        var form_id = form_list_id + '_' + question_id;

        //선택한 input 폼 리스트 제거
        $('#' + form_id).remove();

        reflesh_form_id(id);
    }

    function reflesh_form_id(id) {
        var form_list_id = "{{$config->get('id')}}_question_form_list_" + id;
        var list_tr = document.getElementById(form_list_id).getElementsByTagName('tr');

        var config_id = "{{$config->get('id')}}";

        let new_list_id = '';
        for(let i = 0; i < list_tr.length; i++) {
            new_list_id = form_list_id + '_' + (i + 1);

            //tr 새 아이디 지정
            list_tr[i].id = new_list_id;

            //input 새 아이디 지정
            list_tr[i].getElementsByTagName('input')[0].id = config_id + '_question_' + id + '_radio_' + (i+1);
            list_tr[i].getElementsByTagName('input')[1].name = config_id + '_question_' + id + '_text_' + (i+1);
        }
        setQuestions();
    }
</script>
