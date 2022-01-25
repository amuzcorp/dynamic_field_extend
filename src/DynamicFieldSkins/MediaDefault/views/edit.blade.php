<?php $code = Illuminate\Support\Str::random(16); ?>
<script src="/assets/vendor/jqueryui/jquery-ui.min.js"></script>
<script src="/assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js"></script>
@expose_route('auth.admin')
@expose_route('media_library.index')
@expose_route('media_library.drop')
@expose_route('media_library.get_folder')
@expose_route('media_library.store_folder')
@expose_route('media_library.update_folder')
@expose_route('media_library.move_folder')
@expose_route('media_library.get_file')
@expose_route('media_library.update_file')
@expose_route('media_library.modify_file')
@expose_route('media_library.move_file')
@expose_route('media_library.upload')
@expose_route('media_library.download_file')
<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id')}}_column" id="{{$code}}_{{$config->get('id')}}_column" value="{{json_encode($media)}}">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <div>
        <button type="button" class="xe-btn" onclick="media_popup('{{$config->get('id')}}', '{{$code}}')"><i class="xi-plus"></i> 미디어
            라이브러리
        </button>
    </div>
    <ul class="thumb_{{$config->get('id')}}" id="{{$code}}_thumb_{{$config->get('id')}}" style="padding-left: 0px;">
        @if(isset($media) && $media != 'null')
            @foreach($media as $data)
                @if(XeStorage::find($data))
                    @php
                        $img_ok = array("gif", "png", "jpg", "jpeg", "bmp", "GIF", "PNG", "JPG", "JPEG", "BMP");
                        $file_ext = explode(".", strrev(XeStorage::find($data)->filename));
                        $file_ext = strrev($file_ext[0]);
                    @endphp
                    @if(in_array($file_ext, $img_ok))
                        <li class="media_li" onclick="media_del(this, '{{$config->get('id')}}', '{{$code}}', '{{$data}}')">
                            <img width=100px height=100px src="{{$storage_path.'/'.XeStorage::find($data)->path.'/'.XeStorage::find($data)->filename}}">
                            <input type="hidden" class="{{$data}}" value="{{$data}}">
                            <button type="button" class="btn-delete media_del_btn"><i class="xi-close"></i><span class="xe-sr-only">첨부삭제</span></button>
                        </li>
                    @elseif(!in_array($file_ext, $img_ok))
                        <li class="media_li" onclick="media_del(this, '{{$config->get('id')}}', '{{$code}}', '{{$data}}')">{{XeStorage::find($data)->clientname}}
                            <input type="hidden" class="{{$data}}" value="{{$data}}">
                            <button type="button" class="btn-delete media_del_btn"><i class="xi-close"></i><span class="xe-sr-only">첨부삭제</span></button>
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    </ul>
</div>
<script>
    //id : 유저id
    //rating : 유저권한
    var user = {
        id: XE.config.getters['user/id'],
        rating: XE.config.getters['user/rating']
    }

    function media_popup(media_id, code) {
        var cnt = 0;

        XE.app('MediaLibrary').then(function (appMediaLibrary) {
            appMediaLibrary.open({
                listMode: 2,
                user: user,
                selected: function (mediaList) {
                    // $('.thumb_' + media_id).empty();
                    // if(mediaList.length==0){
                    //     $('.thumb_' + media_id).append("<input type='hidden' name='"+media_id+"_column[]'>");
                    // }
                    $.each(mediaList, function () {
                        //that._renderMedia(this, $form)
                        //that._insertToDocument(that._normalizeFileData(this), $form)

                        //console.log(mediaList[cnt]['file']);

                        var over_chk = $('#'+code+'_thumb_' + media_id).find("input." + mediaList[cnt]['file']['id']).val();
                        // var over_chk = $('.thumb_' + media_id).find("input." + mediaList[cnt]['file']['id']).val();
                        if(mediaList[cnt]['file']['id'] != "") {
                            if (over_chk == null) {
                                var img_string = '';

                                if(checkURL(mediaList[cnt]['file']['filename'])) {
                                    img_string = `<li class="media_li" onclick="media_del(this, '${media_id}', '${code}', '${mediaList[cnt]['file']['id']}')"><img width=100px height=100px src="${mediaList[cnt]['file']['url']}">`;
                                }else{
                                    img_string = `<li class="media_li" onclick="media_del(this, '${media_id}', '${code}', '${mediaList[cnt]['file']['id']}')">${mediaList[cnt]['file']['clientname']}`;
                                }
                                img_string += `<input type="hidden" class="${mediaList[cnt]['file']['id']}" value="${mediaList[cnt]['file']['id']}">`;
                                // img_string += `<input type="hidden" name="${media_id}_column[]" class="${mediaList[cnt]['file']['id']}" value="${mediaList[cnt]['file']['id']}">`;
                                img_string += '<button type="button" class="btn-delete media_del_btn"><i class="xi-close"></i><span class="xe-sr-only">첨부삭제</span></button>';
                                img_string += '</li>';
                                if (mediaList[cnt]['file']['filename']) {
                                    addItem(media_id, code, mediaList[cnt]['file']['id']);
                                    $('#'+code+'_thumb_' + media_id).append(img_string);
                                }
                                cnt++;
                            }

                        }
                    })
                }
            })
        })
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

    function checkURL(url) {
        return(url.match(/(.*?)\.(jpg|jpeg|png|gif|bmp|pdf)$/) != null);
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

<style>
    .media_li {
        position: relative;
        list-style-type: none;
        display: inline;
        margin-right: 12px;
    }

    .media_li:hover {
        cursor: pointer;
    }

    .media_del_btn{
        position: absolute;
        z-index: 5;
        right: 4px;
        padding: 0;
        width: 18px;
        line-height: 18px;
        cursor: pointer;
        color: #fff;
        border: none;
        outline: none;
        background-color: transparent;
        /*top:-77px;*/
        font-size:12px;
    }
</style>

