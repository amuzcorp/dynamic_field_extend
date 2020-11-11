{{XeFrontend::js('plugins/dynamic_field/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field/assets/jquery.edittable.min.css')->load()}}

<div>
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>

    {{--<div>--}}



    {{--<textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id')."_column"}}" >--}}

    {{--</textarea>--}}

    {{--<script>--}}
    {{--$(window).ready(function () {--}}
    {{--$('#{{$config->get("id")."_table"}}').editTable();--}}
    {{--});--}}


    {{--</script>--}}


    {{--</div>--}}

    <div>


        <textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id')."_column"}}" ></textarea>
        {{--제목 : <input type="text" id="my_header">--}}
        <button type="button" onclick="reset_table()">초기화</button>
        <script>
            var my_table;
            $(window).ready(function () {
                //$('#{{$config->get("id")."_table"}}').editTable();
                my_table = $('#{{$config->get("id")."_table"}}').editTable({
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
                    headerCols: ['항목1','항목2','항목3','체크박스'],
                    first_row: true,
                });

                $('#{{$config->get("id")."_table"}} ~table tbody td:nth-child(4)').contents().unwrap().wrap( '<td><input type=text></td>' );
            });

            function reset_table() {
                my_table.reset();
                $('#{{$config->get("id")."_table"}} ~table tbody td:nth-child(4)').contents().unwrap().wrap( '<td><input type=text></td>' );
            }

            function change_table() {

                //var header_data = document.getElementById('my_header').value.split(',');
                //var template_data = document.getElementById('my_chk').value.split(',');
                $('#{{$config->get("id")."_table"}} ~table').remove();
                $('#{{$config->get("id")."_table"}}').editTable({
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
                    headerCols: ['A','B','C','CHK'],
                    first_row: true,
                });

                $('#{{$config->get("id")."_table"}} ~table tbody td:nth-child(4)').contents().unwrap().wrap( '<td><input type=text></td>' );
                //$( 'h2' ).contents().unwrap().wrap( '<p></p>' );
            }


        </script>


    </div>
</div>