<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    {{--<div>--}}
    {{--<button type="button" class="xe-btn" onclick=media_popup("{{$config->get('id')}}")><i class="xi-plus"></i> 미디어 라이브러리</button>--}}
    {{--</div>--}}
    <div class="thumb_{{$config->get('id')}}">
        @if($media)
            @foreach((array)$media as $data)
                {{--{{var_dump(XeStorage::find($data))}}--}}
                @if(XeStorage::find($data))
                    @php
                        $img_ok = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
                        $file_ext = explode(".", strrev(XeStorage::find($data)->filename));
                        $file_ext = strrev($file_ext[0]);
                    @endphp
                    @if(in_array($file_ext, $img_ok))
                        <div>
                            <img src="{{$storage_path.'/'.XeStorage::find($data)->path.'/'.XeStorage::find($data)->filename}}">
                        </div>
                    @else
                        <div>
                            {{XeStorage::find($data)->clientname}}
                            <a href="#" onclick="downloadFile_{{$config->get('id')}}('{{$storage_path.'/'.XeStorage::find($data)->path.'/'.XeStorage::find($data)->filename}}', '{{XeStorage::find($data)->clientname}}')"><b>[다운로드]</b></a>
                        </div>
                    @endif
                @endif
            @endforeach
        @endif

    </div>
</div>

<script type="text/javascript">
    function downloadFile_{{$config->get('id')}}(upfile_path, upfile_name) {
        var req = new XMLHttpRequest();
        //server side code를 호출할 url을 "file_download_url" 에 작성한다.
        req.open("GET", upfile_path, true);
        req.responseType = "blob";
        req.onload = function (event) {
            var blob = req.response;
            var fileName = upfile_name;

            if(window.navigator && window.navigator.msSaveOrOpenBlob){
                window.navigator.msSaveBlob(blob, fileName);
            }else{
                //server side code에서 Content-Disposition 값을 설정하여
                //파일을 다운로드 받을 경우 javaScript 함수를 거치지 않을 경우
                //해당 값(Content-Disposition)에 세팅한 파일명으로 다운로드 받는다.
                //javaScript 함수를 이용할 경우 fileName과 같은
                // 파일명을 의미하는 key값을 이용하여
                //파일명을 아래와 같이 세팅할 수도 있다.

                var link=document.createElement('a');
                link.href=window.URL.createObjectURL(blob);
                link.download=fileName;
                link.click();
            }
        };
        req.send();
    }
</script>
{{--<input type="hidden" name="{{$config->get('id').'_column'}}" id="{{$config->get('id').'_column'}}" value="{{$config->get('id')}}">--}}
