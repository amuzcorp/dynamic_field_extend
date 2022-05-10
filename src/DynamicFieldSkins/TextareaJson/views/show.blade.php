{{ XeFrontend::js('//code.jquery.com/jquery-3.6.0.slim.min.js')->load() }}
{{ XeFrontend::js('plugins/dynamic_field_extend/src/DynamicFieldSkins/TextareaJson/assets/js/simpleJson.js')->load() }}

{{ XeFrontend::css('plugins/dynamic_field_extend/src/DynamicFieldSkins/TextareaJson/assets/css/simpleJson.css')->load() }}
<style>
    .json_parser .json_parser_content {
        margin-top:10px;
        padding: 10px;
        background-color: #f5f5f5;
        border: 1px solid #000;
        word-break: break-all;
    }
    .text-blue {
        color: -webkit-link;
        cursor: pointer;
        text-decoration: underline;
    }
</style>

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <a class="btn btn-info text-blue" onclick="viewJsonViewer('{{$config->get('id')}}')">JSON 뷰어로 보기</a>
    <input type="hidden" name="{{$config->get('id')}}_viwer" value="N" />
    <div class="form-group json_parser">
        <textarea id="{{$config->get('id')}}_dynamicJson"
                  style="width: 700px;height: 400px;"
                  readonly
                  disabled
                  placeholder="{{xe_trans($config->get('placeholder', ''))}}" >{{$data['text']}}</textarea><br />
        <div class="json_parser_content" id="{{$config->get('id')}}_dynamicJson-output" style="display: none;"></div>
    </div>
</div>

<script language="javascript">
    function viewJsonViewer(field_id) {
        if($('input[name='+field_id+'_viwer]').val() === 'N') {
            $('input[name='+field_id+'_viwer]').val('Y');
            document.getElementById(field_id+"_dynamicJson-output").style.display = 'block';
            setJsonParse(field_id);
        } else {
            $('input[name='+field_id+'_viwer]').val('N');
            document.getElementById(field_id+"_dynamicJson-output").style.display = 'none';
            $("#"+field_id+"_dynamicJson-output").empty();
        }
        return false;
    }

    function setJsonParse(field_id) {
        try {
            $("#"+field_id+"_dynamicJson-output").empty();
            var o = $("#"+field_id+"_dynamicJson").val();
            if(is_json(o)) {
                var processedObject = JSON.parse(o);
                $("#"+field_id+"_dynamicJson-output").simpleJson({ jsonObject: processedObject });
            } else {
                document.getElementById(field_id+"_dynamicJson-output").innerHTML = "JSON 인코딩이 유효하지 않습니다.<br>코드를 확인해주세요";
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

