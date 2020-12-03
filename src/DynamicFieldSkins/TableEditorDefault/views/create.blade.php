{{XeFrontend::js('plugins/dynamic_field_extend/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field_extend/assets/jquery.edittable.min.css')->load()}}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>

    <div>



    <textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id')."_column"}}" >

    </textarea>

        <script>
            $(window).ready(function () {
                $('#{{$config->get("id")."_table"}}').editTable();
            });


        </script>


    </div>

    {{--<div>--}}



    {{--<form method="post" action="output.php">--}}
    {{--<textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id')."_column"}}" >--}}

    {{--</textarea>--}}
    {{--제목 : <input type="text" id="my_header">,--}}
    {{--형식 : <input type="text" id="my_chk">--}}
    {{--<button type="button" onclick="change_table()">적용</button>--}}
    {{--<script>--}}
    {{--$(window).ready(function () {--}}
    {{--$('#{{$config->get("id")."_table"}}').editTable();--}}

    {{--});--}}

    {{--function change_table() {--}}
    {{--var header_data = document.getElementById('my_header').value.split(',');--}}
    {{--var template_data = document.getElementById('my_chk').value.split(',');--}}
    {{--$('#{{$config->get("id")."_table"}} ~table').remove();--}}
    {{--$('#{{$config->get("id")."_table"}}').editTable({--}}
    {{--field_templates: {--}}
    {{--'checkbox' : {--}}
    {{--html: '<input type="checkbox"/>',--}}
    {{--getValue: function (input) {--}}
    {{--return $(input).is(':checked');--}}
    {{--},--}}
    {{--setValue: function (input, value) {--}}
    {{--if ( value ){--}}
    {{--return $(input).attr('checked', true);--}}
    {{--}--}}
    {{--return $(input).removeAttr('checked');--}}
    {{--}--}}
    {{--},--}}
    {{--'textarea' : {--}}
    {{--html: '<textarea/>',--}}
    {{--getValue: function (input) {--}}
    {{--return $(input).val();--}}
    {{--},--}}
    {{--setValue: function (input, value) {--}}
    {{--return $(input).text(value);--}}
    {{--}--}}
    {{--},--}}
    {{--'select' : {--}}
    {{--html: '<select><option value="">None</option><option>All</option></select>',--}}
    {{--getValue: function (input) {--}}
    {{--return $(input).val();--}}
    {{--},--}}
    {{--setValue: function (input, value) {--}}
    {{--var select = $(input);--}}
    {{--select.find('option').filter(function() {--}}
    {{--return $(this).val() == value;--}}
    {{--}).attr('selected', true);--}}
    {{--return select;--}}
    {{--}--}}
    {{--}--}}
    {{--},--}}
    {{--row_template: template_data,--}}
    {{--headerCols: header_data--}}
    {{--});--}}
    {{--}--}}


    {{--</script>--}}


    {{--</div>--}}
</div>