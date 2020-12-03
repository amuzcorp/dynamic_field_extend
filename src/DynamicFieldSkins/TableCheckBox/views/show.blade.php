{{XeFrontend::js('plugins/dynamic_field_extend/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field_extend/assets/jquery.edittable.min.css')->load()}}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    {{--{{json_decode($args[$config->get('id').'_column'])}}--}}
    <div>
        <textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id').'_column'}}" readonly>
            {{$args[$config->get('id').'_column']}}

        </textarea>

        <script>
            {{--var my_data = JSON.parse(JSON.stringify("{{$args[$config->get('id').'_column']}}").replace(/&quot;/g, '"'));--}}
            {{--console.log(my_data);--}}

            $(window).ready(function () {
                //field_templates를 수정 checkbox를 수정 getValue, setValue를 통해서 데이터 가져오고 셋팅
                $('#{{$config->get("id")."_table"}}').editTable(
                    {
                        field_templates: {
                            'checkbox' : {
                                html: '<input type="checkbox"/>',
                                getValue: function (input) {
                                    if($(input).attr("type")=="text"){
                                        return $(input).val();
                                    }else if($(input).attr("type")=="checkbox"){
                                        return $(input).is(':checked');
                                    }
                                },
                                setValue: function (input, value) {
                                    if($(input).attr("type")=="text"){
                                        return $(input).text(value);
                                    }else if($(input).attr("type")=="checkbox"){
                                        if ( value ){
                                            return $(input).attr('checked', true);
                                        }
                                        return $(input).removeAttr('checked');
                                    }

                                }
                            },
                            'textarea' : {
                                html: '<textarea/>',
                                getValue: function (input) {
                                    return $(input).val();
                                },
                                setValue: function (input, value) {
                                    return $(input).text(value);
                                }
                            },
                            'select' : {
                                html: '<select><option value="">None</option><option>All</option></select>',
                                getValue: function (input) {
                                    return $(input).val();
                                },
                                setValue: function (input, value) {
                                    var select = $(input);
                                    select.find('option').filter(function() {
                                        return $(this).val() == value;
                                    }).attr('selected', true);
                                    return select;
                                }
                            }
                        },
                        row_template: ['text','text','text','checkbox'],
                        headerCols: ['항목1','항목2','항목3','항목4']
                    }
                );

            //첫행 체크박스를 텍스트로 변경
            $('#{{$config->get("id")."_table"}} ~table tbody tr:nth-child(1) > td:nth-child(4)').html(
                '<input type="text" value="@if(isset(json_decode($args[$config->get("id")."_column"])[0][3])){{json_decode($args[$config->get("id")."_column"])[0][3]}}@endif">');
                $('.inputtable input').attr('readonly',true);
                $('.inputtable input:checkbox').attr('disabled',true);
            });


        </script>


    </div>
</div>

<style>
    table.inputtable td:last-child, table.inputtable th:last-child
    {
        display: none;
    }

    table.inputtable thead
    {
        display: none;
    }

    /*table.inputtable.wh tbody tr:nth-child(1), table.inputtable.wh tbody tr:nth-child(1) input*/
    /*{*/
    /*background: #f1f1f1;*/
    /*border-color:#ddd;*/
    /*}*/

</style>