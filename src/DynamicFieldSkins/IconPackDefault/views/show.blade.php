<div>
        <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label><br>
    @if(strpos($data['column'], "xi-spinner") !== false)
        <div class="my{{$config->get('id')}}_div {{$data['column']}} xi-3x xi-spin"></div>
    @else
        <div class="my{{$config->get('id')}}_div {{$data['column']}} xi-3x" ></div>
    @endif
</div>

{{--<script>--}}

    {{--function icon_popup() {--}}
        {{--$(".layer").css("display","block");--}}
    {{--}--}}

    {{--function icon_on(my{{$config->get('id')}}_div) {--}}
        {{--document.querySelector(".my{{$config->get('id')}}_div").setAttribute('class',"my{{$config->get('id')}}_div xi-3x");--}}
        {{--var my_iconClass = my{{$config->get('id')}}_div.getAttribute('class').replace(" xi-3x","");--}}
        {{--document.querySelector(".my{{$config->get('id')}}_div").classList.add(my_iconClass);--}}
        {{--document.getElementById("{{$config->get('id')}}_id").value=my_iconClass;--}}
        {{--$(".layer").css("display","none");--}}
    {{--}--}}

    {{--function icon_off(my{{$config->get('id')}}_div) {--}}
        {{--my{{$config->get('id')}}_div.setAttribute('class',"my{{$config->get('id')}}_div xi-3x");--}}
    {{--}--}}


{{--</script>--}}
{{--<style type="text/css">--}}
    {{--/*.layer {*/--}}
    {{--/*position: absolute;*/--}}
    {{--/*text-align: center;*/--}}
    {{--/*width: 100%;*/--}}
    {{--/*height: 100%;*/--}}
    {{--/*top: 0;*/--}}
    {{--/*left: 0;*/--}}
    {{--/*font-size: 50px;*/--}}
    {{--/*display: none;*/--}}
    {{--/*}*/--}}
    {{--/*.layer .content {*/--}}
    {{--/*display: inline-block;*/--}}
    {{--/*vertical-align: middle*/--}}
    {{--/*}*/--}}
    {{--/*.layer .blank {*/--}}
    {{--/*display: inline-block;*/--}}
    {{--/*width: 0;*/--}}
    {{--/*height: 100%;*/--}}
    {{--/*vertical-align: middle*/--}}
    {{--/*}*/--}}

    {{--.layer{--}}
        {{--display: none;--}}
    {{--}--}}
{{--</style>--}}

