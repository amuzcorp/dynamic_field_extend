{{ XeFrontend::js('//code.jquery.com/jquery-3.6.0.slim.min.js')->load() }}
{{ XeFrontend::js('plugins/dynamic_field_extend/src/DynamicFieldSkins/TextareaJson/assets/js/simpleJson.js')->load() }}

{{ XeFrontend::css('plugins/dynamic_field_extend/src/DynamicFieldSkins/TextareaJson/assets/css/simpleJson.css')->load() }}
<style>
    .json_parser .json_parser_content {
        padding: 10px;
        background-color: #f5f5f5;
        border: 1px solid #000;
    }
</style>
<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}} <small>{{$config->get('id')}}</small></label>
    <br />
    <label><small>json 포맷만 이용이 가능합니다</small></label>
    <div class="form-group json_parser">
        <textarea id="{{$config->get('id')}}_dynamicJson"
                  name="{{$key['text']}}"
                  style="width: 700px;height: 400px;"
                  placeholder="{{xe_trans($config->get('placeholder', ''))}}"
                  data-valid-name="{{ xe_trans($config->get('label')) }}"
        >{ "val1": "bob", "val2": false, "nestedObj": { "val3": "ug" }}</textarea><br />
        <div class="json_parser_content" id="{{$config->get('id')}}_dynamicJson-output"></div>
    </div>
</div>

<script language="javascript">
    $(document).ready(function () {
        setJsonParse();
        $("#{{$config->get('id')}}_dynamicJson").keyup(function() {
            setJsonParse();
        })
    });

    function setJsonParse() {
        try {
            $("#{{$config->get('id')}}_dynamicJson-output").empty();
            var o = $("#{{$config->get('id')}}_dynamicJson").val();
            if(is_json(o)) {
                var processedObject = JSON.parse(o);
                $("#{{$config->get('id')}}_dynamicJson-output").simpleJson({ jsonObject: processedObject });
            } else {
                document.getElementById("{{$config->get('id')}}_dynamicJson-output").innerHTML = "JSON 인코딩이 유효하지 않습니다.<br>코드를 확인해주세요";
            }
        } catch (ex) {
        }
    }

    function is_json(msg) {
        var IS_JSON = true;
        try {
            var json = $.parseJSON(msg);
        } catch(err) {
            IS_JSON = false;
        }

        return IS_JSON;
    }
</script>

