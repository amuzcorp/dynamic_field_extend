<?php $code = Illuminate\Support\Str::random(16); ?>
<script src="/assets/vendor/jqueryui/jquery-ui.min.js"></script>
<script src="/assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js"></script>

<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id')}}_column" id="{{$code}}_{{$config->get('id')}}_column" value="null">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <div class="mb-3">
        <input class="form-control" type="file" accept="image/*" id="{{$config->get('id').'_uploader'}}">
    </div>

    <ul class="thumb_{{$config->get('id')}}" id="{{$code}}_thumb_{{$config->get('id')}}" style="padding-left: 0px;"></ul>

    {{--<input type="hidden" name="{{$config->get('id').'_column'}}" id="{{$config->get('id').'_column'}}" value="{{$config->get('id')}}">--}}
</div>
<script>
    //id : 유저id
    //rating : 유저권한
    var user = {
        id: XE.config.getters['user/id'],
        rating: XE.config.getters['user/rating']
    }
    $(function() {
        $("#{{$config->get('id')}}_uploader").change(function (e) {
            const imageInput = $("#{{$config->get('id')}}_uploader")[0];
            // 파일을 여러개 선택할 수 있으므로 files 라는 객체에 담긴다.
            if(imageInput.files.length === 0){
                alert("파일은 선택해주세요");
                return;
            }
            const formData = new FormData();
            formData.append("file", imageInput.files[0]);

            var cnt = 0;
            window.XE.ajax({
                type:"POST",
                dataType: "json",
                url: '{{route('media_library.upload')}}',
                processData: false,
                contentType: false,
                data: formData,
                success: function (mediaList) {
                    if(mediaList.length < 1) {
                        XE.toast('danger', '이미지 정보를 불러오는데 실패 했습니다');
                    } else {
                        var media_id = "{{$config->get('id')}}";
                        var code = "{{$code}}"

                        $.each(mediaList, function () {
                            var over_chk = $('#' + code + '_thumb_' + media_id).find("input." + mediaList[cnt]['file']['id']).val();
                            // var over_chk = $('.thumb_' + media_id).find("input." + mediaList[cnt]['file']['id']).val();
                            if (mediaList[cnt]['file']['id'] != "") {
                                if (over_chk == null) {
                                    var img_string = '';
                                    if (checkURL(mediaList[cnt]['file']['filename'])) {
                                        img_string = `<li class="media_li" onclick="media_del(this, '${media_id}', '${code}', '${mediaList[cnt]['file']['id']}')">
                                                            <img width=100px height=100px src="${mediaList[cnt]['file']['url']}">`;
                                    } else {
                                        img_string = `<li class="media_li" onclick="media_del(this, '${media_id}', '${code}', '${mediaList[cnt]['file']['id']}')">${mediaList[cnt]['file']['clientname']}`;
                                    }
                                    img_string += `<input type="hidden" class="${mediaList[cnt]['file']['id']}" value="${mediaList[cnt]['file']['id']}">`;
                                    // img_string += `<input type="hidden" name="${media_id}_column[]" class="${mediaList[cnt]['file']['id']}" value="${mediaList[cnt]['file']['id']}">`;
                                    img_string += '<button type="button" class="btn-delete media_del_btn"><i class="xi-close"></i><span class="xe-sr-only">첨부삭제</span></button>';
                                    img_string += '</li>';
                                    if (mediaList[cnt]['file']['filename']) {
                                        addItem(media_id, code, mediaList[cnt]['file']['id']);
                                        $('#' + code + '_thumb_' + media_id).append(img_string);
                                    }
                                    cnt++;
                                }

                            }
                        });
                    }
                }
            });
        });
    });

    function checkURL(url) {
        return(url.match(/(.*?)\.(jpg|jpeg|png|gif|bmp|pdf)$/) != null);
    }

    function media_del(my_data, media_id, code, image_id) {
        var column_value = $("#"+code+'_'+media_id+'_column').val();
        column_value = JSON.parse(column_value);
        const index = column_value.indexOf(image_id);
        if (index > -1) {
            column_value.splice(index, 1);
        }
        if(column_value.length === 0) $("#"+code+'_'+media_id+'_column').val("null");
        else $("#"+code+'_'+media_id+'_column').val(JSON.stringify(column_value));

        my_data.remove();
    }

    function addItem(media_id, code, image_id) {
        //{$code}}_{$config->get('id')}}_column
        var column_value = $("#"+code+'_'+media_id+'_column').val();
        if(column_value === "null" || column_value === undefined) {
            var array = [];
            array.push(image_id);

            $("#"+code+'_'+media_id+'_column').val(JSON.stringify(array));
        } else {
            column_value = JSON.parse(column_value);
            column_value.push(image_id);

            $("#"+code+'_'+media_id+'_column').val(JSON.stringify(column_value));
        }
    }

</script>
