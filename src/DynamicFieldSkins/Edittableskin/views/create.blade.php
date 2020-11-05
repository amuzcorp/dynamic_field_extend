{{XeFrontend::js('plugins/dynamic_field_extend/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field_extend/assets/jquery.edittable.min.css')->load()}}

<div>
<label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>

    <div>

        {{--<div id="edittable"></div>--}}
        {{--<a href="#" class="sendjson button">Send JSON (check your console)</a>--}}
        {{--<a href="#" class="loadjson button">Load JSON from textarea</a>--}}
        {{--<a href="#" class="reset button">Reset Table</a>--}}


        {{--<script>--}}
            {{--// Initialize table example 1--}}
            {{--var eTable = $('#edittable').editTable({--}}
                {{--data: [--}}
                    {{--["Click on the plus symbols on the top and right to add cols or rows"]--}}
                {{--]--}}
            {{--});--}}

            {{--// Load json data trough an ajax call--}}
            {{--$('.loadjson').click(function () {--}}
                {{--var _this = $(this),text = $(this).text();--}}
                {{--$(this).text('Loading...');--}}
                {{--$.ajax({--}}
                    {{--url: 	'output.php',--}}
                    {{--type: 	'POST',--}}
                    {{--data: 	{--}}
                        {{--ajax: true--}}
                    {{--},--}}
                    {{--complete: function (result) {--}}
                        {{--_this.text(text);--}}
                        {{--eTable.loadJsonData(result.responseText);--}}
                    {{--}--}}
                {{--});--}}
                {{--return false;--}}
            {{--});--}}

            {{--// Reset table data--}}
            {{--$('.reset').click(function () {--}}
                {{--eTable.reset();--}}
                {{--return false;--}}
            {{--});--}}

            {{--// Send JSON data trough an ajax call--}}
            {{--$('.sendjson').click(function () {--}}
                {{--$.ajax({--}}
                    {{--url: 	'output.php',--}}
                    {{--type: 	'POST',--}}
                    {{--data: 	{--}}
                        {{--ajax: true,--}}
                        {{--data: eTable.getJsonData()--}}
                    {{--},--}}
                    {{--complete: function (result) {--}}
                        {{--console.log(JSON.parse(result.responseText));--}}
                    {{--}--}}
                {{--});--}}
                {{--return false;--}}
            {{--});--}}
        {{--</script>--}}

        {{--<form method="post" action="output.php">--}}
        <textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id')."_column"}}" >

        </textarea>
        {{--<button type="button" onclick="t_test()">Send data</button>--}}
        {{--</form>--}}

        <script>
            $(window).ready(function () {
                $('#{{$config->get("id")."_table"}}').editTable();
            });


        </script>


    </div>
</div>