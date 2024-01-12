<script>
    function viewDocumentListModal() {

        var instance_id = "{{$config->get('r_instance_id')}}";
        var page_name = "{{$config->get('id')}}_page";
        var page = $('input[name='+ page_name +']').val();
        console.log(instance_id);
        if(instance_id) {
            var params = {
                instance_id: instance_id,
                page: page
            };
            XE.ajax({
                type: 'post',
                data: params,
                url: '{{route('dynamic_field_extend.ajax.callDocumentList')}}',
                success: function (response) {
                    var response_data = response.data.data;

                    var form_id = "{{$config->get('id')}}_form_list";

                    var str = '';
                    for(let item of response_data ) {
                        str += `
                        <tr>
                            <td>
                                <span>${item.title}</span>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" onclick="selectQuestions('${item.id}', '${item.title}')">선택</a>
                            </td>
                        </tr>
                        `;
                    }
                    document.getElementById(form_id).innerHTML = str;
                    document.getElementById('viewDocumentList').click();
                }
            });
        }
    }

    function selectQuestions(id, title) {
        var selected_badge = "{{$config->get('label')}}_selected_document";
        var doc_id = "{{$config->get('id')}}_doc_id";
        var result = "{{$config->get('id')}}_result";
        var instance_id = "{{$config->get('r_instance_id')}}";

        var question_field = "{{$config->get('target_field_id')}}_columns";
        document.getElementById(selected_badge).innerText = "선택된 문서가 없습니다";

        var params = {
            instance_id : instance_id,
            doc_id : id,
            question_field: question_field
        };
        XE.ajax({
            type: 'post',
            data: params,
            url: '{{route('dynamic_field_extend.ajax.CallQuestionField')}}',
            success: function (response) {
                $('input[name='+ doc_id +']').val(id);
                document.getElementById(selected_badge).innerText = title;
                var str = '';
                for(let i = 0; i < response.data.length; i++) {

                    str += `
                        <table class="table text-center question_form">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <input type="text"
                                           class="form-control"
                                           value="${response.data[i].title}"
                                           readonly>
                                </td>
                            </tr>
                        </thead>
                        <tbody>`;
                    if (response.data[i].question_type === 1) {
                        for (let q = 0; q < response.data[i].questions.length; q++) {
                            if(response.data[i].question_check_type === 1) {
                                str += `
                                <tr>
                                    <td style="width:5%;">
                                    <input type="radio"
                                           name="{{$config->get('target_field_id')}}_question_${(i + 1)}_radio" value="${(q + 1)}"
                                           onchange="setQuestions( '{{$config->get('target_field_id')}}_question_${(i + 1)}_radio', ${(i + 1)}, ${q + 1}, this )">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control mb-5px" value="${response.data[i].questions[q].value}" readonly>
                                    </td>
                                </tr>`;
                            } else {
                                str += `
                                <tr>
                                    <td style="width:5%;">
                                    <input type="checkbox"
                                           id="customCheck${(i + 1)}_${q + 1}"
                                           name="{{$config->get('target_field_id')}}_question_${(i + 1)}_check_${q + 1}" value="${(q + 1)}"
                                           value="${q + 1}"
                                           data-parsley-multiple="groups"
                                           data-parsley-mincheck="1"
                                           onchange="setQuestions( '{{$config->get('target_field_id')}}_question_${(i + 1)}_check_${q + 1}', ${(i + 1)}, ${q + 1}, this )">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control mb-5px" value="${response.data[i].questions[q].value}" readonly>
                                    </td>
                                </tr>`;
                            }
                        }
                    } else {
                        str += `
                        <tr>
                            <td colspan="2">
                                <textarea class="form-control"
                                onchange="setQuestions( '', ${(i + 1)}, 0 , this)"></textarea>
                            </td>
                        </tr>
                        `;
                    }
                    str += `</tbody>
                </table>`;
                }
                document.getElementById('question_form').innerHTML = str;
                $('input[name={{$config->get('target_field_id')}}_columns]').val(response.data.length);
                document.getElementById("{{$config->get('id')}}_closeModal").click();

                let answer = [];
                let check_type = 0;
                let question_type = 0;
                var checked = [];

                for(let item of response.data) {

                    check_type = item.question_check_type;
                    question_type = item.question_type;
                    checked = [];
                    if(item.question_check_type === 2) {
                        for(let question of item.questions) {
                            checked.push(false);
                        }
                    }

                    answer.push(
                        {
                            check_type: check_type,
                            question_type: question_type,
                            selected: 0,
                            checked: checked,
                            text: '',
                        }
                    )
                }

                var question_result = {
                    answer: false,
                    result: answer
                };

                console.log(question_result);
                $('input[name='+result+']').val(JSON.stringify(question_result));

            }
        });
    }

    function setQuestions( name, question, checked, item ) {
        var result = "{{$config->get('id')}}_result";
        var question_result = JSON.parse($('input[name='+result+']').val());
        var answer = question_result.result;

        if(answer[(+question) - 1].question_type === 1) {
            if(answer[(+question) - 1].check_type === 1) {
                question_result.answer = true;
                answer[(+question) - 1].selected = checked;
            } else if(answer[(+question) - 1].check_type === 2) {
                question_result.answer = true;
                answer[(+question) - 1].checked[checked] = item.checked;
            }
        } else {
            question_result.answer = true;
            answer[(+question) - 1].text = item.value;
        }

        // answer[(+question) - 1].selected = checked;

        question_result.result = answer;
        $('input[name={{$config->get('id')}}_result]').val(JSON.stringify(question_result));
    }
</script>
