<label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
<div>
    {{--{{var_dump($args['color_picker_column'])}}--}}
    {{--<input type="color" id="my_color" name="{{$config->get('id').'_column'}}" value="{{$args[$config->get('id').'_column']}}">--}}

    <input type="color" id="{{$config->get('id').'_column'}}" name="{{$config->get('id').'_column'}}" value="{{$args[$config->get('id').'_column']}}" onchange=color_change("{{$config->get('id').'_column'}}")>
    <input type="text" style="color:#555;border:1px solid #dcdde0;font-size: 14px; padding: 7px 16px" id="{{$config->get('id').'_column_text'}}"
           value="{{$args[$config->get('id').'_column']}}"  placeholder="{{xe_trans($config->get('placeholder',''))}}" >
    <button type="button" class="xe-btn") onclick=color_apply("{{$config->get('id').'_column'}}")>적용</button>

</div>

<script>
    function color_apply(input_id) {
        //console.log(my_data.value);
        document.getElementById(input_id).value = document.getElementById(input_id+'_text').value;
        //console.log(document.getElementById(input_id).value);
    }

    function color_change(input_id) {
        //console.log(my_data.value);
        //alert(document.getElementById(input_id).value);
        document.getElementById(input_id+'_text').value = document.getElementById(input_id).value;
        //console.log(document.getElementById(input_id).value);
    }
</script>