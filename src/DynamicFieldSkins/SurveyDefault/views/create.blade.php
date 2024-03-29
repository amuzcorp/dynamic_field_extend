{{XeFrontend::css('plugins/dynamic_field_extend/src/DynamicFieldSkins/SurveyDefault/assets/survey_common.css')->load()}}
<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <div>
        <textarea id="{{$config->get('id')."_table"}}" name="{{$config->get('id')."_column"}}" style="display: none;"></textarea>
        <input class="list_count" type="hidden" value="1">
        <table class="table w-100 text-center">
            <thead>
            <tr>
                <th class="text-center">설문 텍스트</th>
                <th class="text-center" style="width:10%;">그렇다</th>
                <th class="text-center" style="width:10%;">그렇지않다</th>
                <th class="text-center" style="width:10%;">
                    <a class="addrow icon-button" onclick="addSubForm(this)">+</a>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr id="0">
                <td>
                    <input name="{{$config->get('id')."_column0_text"}}" type="text" class="w-100" onkeyup="setParams(this)"/>
                </td>
                <td><input name="{{$config->get('id')."_column0_checkbox1"}}" type="checkbox" onchange="setParams(this)"/></td>
                <td><input name="{{$config->get('id')."_column0_checkbox2"}}" type="checkbox" onchange="setParams(this)"/></td>
                <td>
                    <a class="delrow icon-button bg-danger" onclick="dels(this)">-</a>
                </td>
            </tr>
            </tbody>
        </table>

        <script>
            function setParams(my) {
                $(my).closest('div').find("textarea").val('test');
                {{--console.log($(my).parents("table").parents("div:{{$config->get('id').'_column'}}"));--}}
                var trList = $(my).parents("table").find('tbody').find("tr");
                var inputs = [];
                for(let i = 0; i < trList.length; i++) {
                    inputs.push({
                        text : $(my).parents("table").find($('input[name={{$config->get("id")}}_column' + trList[i].id + '_text')).val(),
                        checkbox1 : $(my).parents("table").find($('input[name={{$config->get("id")}}_column' + trList[i].id + '_checkbox1')).is(":checked"),
                        checkbox2 : $(my).parents("table").find($('input[name={{$config->get("id")}}_column' + trList[i].id + '_checkbox2')).is(":checked"),
                    });
                }
                //list_count

                // console.log($(my).parents("table").find("input"));
                $(my).closest('div').find("textarea").val('');
                $(my).closest('div').find("textarea").val(JSON.stringify(inputs));
            }

            function addSubForm(my) {
                let list_number = $(my).closest('div').find($('input[class=list_count]')).val();
                $(my).closest('div').find($('input[class=list_count]')).val((+list_number) + 1);
                list_number = $(my).closest('div').find($('input[class=list_count]')).val();

                const textName = "{{$config->get('id')}}" + '_column' + list_number + '_text';
                const checkBoxName = "{{$config->get('id')}}" + '_column' + list_number + '_checkbox';
                $(my).parents("table").find('tbody').append('' +
                    '<tr id="'+list_number+'">' +
                    '<td>' +
                    '<input name="'+textName+'" type="text" class="w-100" onkeyup="setParams(this)"/>' +
                    '</td>' +
                    '<td><input name="'+checkBoxName+'1" type="checkbox" onchange="setParams(this)"/></td>' +
                    '<td><input name="'+checkBoxName+'2" type="checkbox" onchange="setParams(this)"/></td>' +
                    '<td><a class="delrow icon-button bg-danger" onclick="dels(this)">-</a></td>' +
                    '</tr>'
                );
            }

            function dels(my) {
                var trList = $(my).parents("table").find('tbody').find("tr");
                if(trList.length > 1) {
                    $(my).parents("tr").remove();
                    var inputs = [];
                    for(let i = 0; i < trList.length; i++) {
                        inputs.push({
                            text : $(my).parents("table").find($('input[name={{$config->get("id")}}_column' + trList[i].id + '_text')).val(),
                            checkbox1 : $(my).parents("table").find($('input[name={{$config->get("id")}}_column' + trList[i].id + '_checkbox1')).is(":checked"),
                            checkbox2 : $(my).parents("table").find($('input[name={{$config->get("id")}}_column' + trList[i].id + '_checkbox2')).is(":checked"),
                        });
                    }
                    // console.log($(my).parents("table").find("input"));
                    $(my).closest('div').find("textarea").val('');
                    $(my).closest('div').find("textarea").val(JSON.stringify(inputs));
                }
            }
        </script>


    </div>
</div>
