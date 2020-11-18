{{--<div class="xi-close xi-2x"></div>--}}
{{--<button type="button" class="xi-close xi-2x"></button>--}}
{{--{{var_dump($data['column'])}}--}}
<label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label><br>
<input type="hidden" id="{{$config->get('id')}}_id" name="{{$config->get('id')}}_column" value="{{$data['column']}}">
<div class="my{{$config->get('id')}}_div {{$data['column']}} xi-3x click_pointer" onclick="icon_off(this,'{{$config->get('id')}}')"></div><br>
<button type="button" class="xe-btn" onclick="icon_popup('{{$config->get('id')}}')">아이콘</button><br><br>

<div class="{{$config->get('id')}}_layer">
    <button type="button" class="icon_popup_close xe-btn" onclick="popup_off('{{$config->get('id')}}')">닫기</button>
    <h class="icon_layer_title">아이콘을 선택해주세요.</h>
    <div class="layer_in">
        {{--<span class="content">아이콘을 선택해주세요.</span><br>--}}
        <h3 class="sub-section-tit" id="action_icon_title">- action</h3>
        @foreach($icon_action as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="content_icon_title">- content</h3>
        @foreach($icon_content as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="communication_icon_title">- communication</h3>
        @foreach($icon_communication as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="message_icon_title">- message</h3>
        @foreach($icon_message as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="editor_icon_title">- editor</h3>
        @foreach($icon_editor as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="hardware_icon_title">- hardware</h3>
        @foreach($icon_hardware as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="media_icon_title">- media</h3>
        @foreach($icon_media as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="map_icon_title">- map</h3>
        @foreach($icon_map as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="ecommerce_icon_title">- e-commerce</h3>
        @foreach($icon_ecommerce as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="file_icon_title">- file</h3>
        @foreach($icon_file as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="technology_icon_title">- technology</h3>
        @foreach($icon_technology as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="spinner_icon_title">- spinner</h3>
        @foreach($icon_spinner as $value)
            <div class="{{$value}} xi-2x xi-spin click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="weather_icon_title">- weather</h3>
        @foreach($icon_weather as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="license_icon_title">- license</h3>
        @foreach($icon_license as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
        <h3 class="sub-section-tit" id="brand_icon_title">- brand</h3>
        @foreach($icon_brand as $value)
            <div class="{{$value}} xi-2x click_pointer" onclick="icon_on(this, '{{$config->get('id')}}')"></div>
        @endforeach
    </div>
</div>


<script>

    function icon_popup(my_id) {
        //$("."+my_id+"_layer").css("display","block");
        var my_stat = document.querySelector("."+my_id+"_layer").style.display;
        if(my_stat=="block"){
            document.querySelector("."+my_id+"_layer").style.display="none";
        }else{
            document.querySelector("."+my_id+"_layer").style.display="block";
        }

    }

    function popup_off(my_id) {
        document.querySelector("."+my_id+"_layer").style.display="none";
    }

    function icon_on(my_div, config_get_id) {
        if(my_div.getAttribute('class').includes("xi-spin")){
            document.querySelector(".my"+config_get_id+"_div").setAttribute('class',"my"+config_get_id+"_div xi-3x xi-spin click_pointer");
        }else{
            document.querySelector(".my"+config_get_id+"_div").setAttribute('class',"my"+config_get_id+"_div xi-3x click_pointer");
        }

        var my_iconClass = my_div.getAttribute('class').replace(" xi-2x","").replace(" xi-spin", "").replace(" click_pointer", "");
        document.querySelector(".my"+config_get_id+"_div").classList.add(my_iconClass);
        document.getElementById(config_get_id+"_id").value=my_iconClass;
        document.querySelector("."+config_get_id+"_layer").style.display="none";
    }

    function icon_off(my_div, config_get_id) {
        my_div.setAttribute('class',"my"+config_get_id+"_div xi-3x");
        document.getElementById(config_get_id+"_id").value = "";
    }


</script>
<style type="text/css">

    .{{$config->get('id')}}_layer{
        display: none;
        height: 300px;
        width: 55%;
        background: #b1b5b2;
        position: fixed;
        top:50%;
        margin-top: -150px;
        z-index: 2;
        left:0px;
        margin-left: 25%;
    }

    .layer_in{
        overflow: auto;
        top:15px;
        height: 250px;
        position: relative;
        background: #ffffff;
    }

    .icon_layer_title{
        top:10px;
        left: 5px;
        position: relative;
        font-weight: bold;
    }

    .icon_popup_close{
        position: relative;
        /*float: right;*/
        top:10px;
        /*left: 10px;*/
        margin-left: 10px;
    }

    .click_pointer{
        cursor:pointer;
    }

</style>

