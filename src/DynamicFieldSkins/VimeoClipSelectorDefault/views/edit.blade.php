{{XeFrontend::js('plugins/dynamic_field_extend/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field_extend/assets/jquery.edittable.min.css')->load()}}

<style>
    .table.videoSelector tbody tr:hover{
        background: rgba(95, 204, 255, 0.43);
        transition: 1s;
        cursor: pointer;
    }
    #vimeoVideoContent {
        width:100%;
        margin-bottom:10px;
    }
    #vimeoVideoContent iframe {
        width: 100% !important;
        height: auto !important;
        min-height: 300px !important;
    }
    .text-white {
        color:#fff !important;
    }
</style>

<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id')}}_vimeo_ids" value="{{$data['vimeo_ids']}}" >
    <div>
        <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic mb-3"><h4>선택한 영상</h4></label>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <colgroup>
                        <col style="width:20%;" />
                        <col style=""/>
                        <col style="width:15%;" />
                    </colgroup>
                    <thead>
                    <tr>
                        <th>디렉토리명</th>
                        <th>영상제목</th>
                        <th>작업</th>
                    </tr>
                    </thead>
                    <tbody id="selectVideoInfo">
                    @foreach($selected as $item)
                        <tr id="{{$item->id}}">
                            <td>
                                {{$item->directory_name}}
                            </td>
                            <td>{{$item->name}}</td>
                            <td>
                                <a class="btn btn-danger text-white" onclick="unselectVideo( {{$item->id}} )">리스트 제거</a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($selected) === 0)
                        <tr>
                            <td colspan="3" style="padding-top:14.5px; padding-bottom:14.5px;">선택된 영상이 없습니다</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic mb-3"><h4>비메오 영상 선택</h4></label>

        <div class="card">
            <div class="card-body">
                <label class="float-left" id="selectDirectory"></label>
                <a class="btn btn-info btn-sm" onclick="syncViemoData()" style="float:right;">비메오 영상 동기화</a>
                <table class="table videoSelector">
                    <colgroup>
                        <col style=""/>
                        <col style="width:15%;" />
                        <col style="width:15%;" />
                    </colgroup>
                    <thead>
                    <tr>
                        <th>명칭</th>
                        <th>타입</th>
                        <th>선택</th>
                    </tr>
                    </thead>
                    <tbody id="vimeoList">
                    @foreach($directories as $directory)
                        <tr onclick="selectDirectory({{$directory->id}}, '{{$directory->name}}')">
                            <td>{{$directory->name}}</td>
                            <td>폴더</td>
                            <td>{{$directory->updated_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a style="display: none;" data-toggle="modal" data-animation="bounce" data-target=".viewVimeoVideoData" id="vimeoOpenModal" data-backdrop="static" data-keyboard="false"></a>

        <div class="modal fade viewVimeoVideoData" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">영상정보</h5>
                    </div>
                    <div class="modal-body">
                        <div id="vimeoVideoContent">

                        </div>
                        <div id="vimeoVideoInfomation">
                            <input type="hidden" name="video_id" value="" >
                            <input type="hidden" name="video_name" value="" >
                            <div class="row">
                                <div class="col-12">
                                    <label>영상제목</label>
                                    <div id="vimeoVideoName"></div>
                                </div>
                                <div class="col-12">
                                    <label>영상재생시간</label>
                                    <div id="vimeoVideoDuration"></div>
                                </div>
                                <div class="col-12">
                                    <label>영상등록일</label>
                                    <div id="vimeoVideoUploadDate"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-info btn-sm py-0 text-white" onclick="selectVideo($('input[name=video_id]').val(), $('input[name=video_name]').val())">영상선택</a>
                        <a class="btn btn-secondary text-white" data-dismiss="modal" id="closeModal">닫기</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
</div>
<script>
    function vimeoSettingCheck() {
        let user_id = '{{$config->get('user_id')}}';
        let client_key = '{{$config->get('client_key')}}';
        let secret_key = '{{$config->get('secret_key')}}';
        let access_token = '{{$config->get('access_token')}}';

        if(user_id === '') {
            alert('설정에서 유저 ID(숫자) 를 등록해주세요');
            return false;
        } else if(client_key === '') {
            alert('설정에서 클라이언트 ID 를 등록해주세요');
            return false;
        } else if(secret_key === '') {
            alert('설정에서 Secret KEY 를 등록해주세요');
            return false;
        } else if(secret_key === '') {
            alert('설정에서 Access Token 을 등록해주세요');
            return false;
        }
        return true;
    }

    function syncViemoData() {
        if(!vimeoSettingCheck()) {
            return false;
        }

        let user_id = '{{$config->get('user_id')}}';
        let client_key = '{{$config->get('client_key')}}';
        let secret_key = '{{$config->get('secret_key')}}';
        let access_token = '{{$config->get('access_token')}}';

        let params = {
            user_id : user_id,
            client_key : client_key,
            secret_key : secret_key,
            access_token : access_token,
        };
        XE.ajax({
            type: 'post',
            dataType: 'json',
            data: params,
            url: '{{route('manage.dynamic_field_extend.syncVimeoProjectData')}}',
            success: function(response) {
                getDirectoryList();
            }
        });
    }

    function selectDirectory(id, name) {
        if(!vimeoSettingCheck()) {
            return false;
        }

        if(id === null) {
            alert('디렉토리를 선택해주세요');
            return false;
        }

        let params = {
            directory : id
        };
        XE.ajax({
            type: 'post',
            dataType: 'json',
            data: params,
            url: '{{route('manage.dynamic_field_extend.getSelectDirectoryVideo')}}',
            success: function(response) {
                document.getElementById('vimeoList').innerHTML = '';
                let videoData = response.data;
                var str = `<tr onclick="getDirectoryList()"><td colspan="3" style="padding-top: 14px; padding-bottom: 14px;">폴더 리스트로</td></tr>`;
                for(let i in videoData){
                    str += `
                        <tr>
                           <td>${videoData[i].name}</td>
                           <td>동영상</td>
                           <td><a class="btn btn-info btn-sm py-0 text-white" onclick="selectVideo(${videoData[i].id}, '${videoData[i].name}')">선택</a><a class="btn btn-primary btn-sm py-0 text-white" onclick="viewVideoData(${videoData[i].id})" >영상</a></td>
                        </tr>`;
                }
                document.getElementById('vimeoList').innerHTML = str;
                document.getElementById('selectDirectory').innerText = name;
            }
        });
    }

    function viewVideoData(id) {
        if(!vimeoSettingCheck()) {
            return false;
        }
        let access_token = '{{$config->get('access_token')}}';

        let params = {
            id : id,
            access_token: access_token
        };
        XE.ajax({
            type: 'get',
            dataType: 'json',
            data: params,
            url: '{{route('dynamic_field_extend.vimeo.getVideoInfo')}}',
            success: function (response) {
                console.log(response);
                document.getElementById('vimeoOpenModal').click();
                document.getElementById('vimeoVideoContent').innerHTML = '';
                document.getElementById('vimeoVideoContent').innerHTML = response.data.embed.html;
                document.getElementById('vimeoVideoName').innerText = response.data.name;
                document.getElementById('vimeoVideoDuration').innerText = response.data.duration + ' 초';
                document.getElementById('vimeoVideoUploadDate').innerText = response.data.created_time;
                $('input[name=video_id]').val(id);
                $('input[name=video_name]').val(response.data.name);
            }
        });
    }

    function selectVideo(id, name) {
        // if (confirm('?') == false) {
        //     return false;
        // }
        var str = `
        <tr id="${id}">
            <td>${document.getElementById('selectDirectory').innerText}</td>
            <td>${name}</td>
            <td>
                <a class="btn btn-danger text-white" onclick="unselectVideo( ${id} )">리스트 제거</a>
            </td>
        </tr>
        `;

        let selectVedio = $('input[name={{$config->get("id")}}_vimeo_ids]').val();

        if(selectVedio === '') {
            document.getElementById('selectVideoInfo').innerHTML = '';
            selectVedio = id;
        } else {
            str = document.getElementById('selectVideoInfo').innerHTML + str;

            if(selectVedio.split(",").includes( "" + id )) return false;

            selectVedio = selectVedio + ',' + id;
        }

        document.getElementById('selectVideoInfo').innerHTML = str;
        document.getElementById('closeModal').click();
        $('input[name={{$config->get("id")}}_vimeo_ids]').val(selectVedio);
    }

    function unselectVideo(id)
    {
        let selectVedio = $('input[name={{$config->get("id")}}_vimeo_ids]').val();

        if(selectVedio.split(",").includes( "" + id )) {
            if(selectVedio.split(",").length > 1) {
                if(selectVedio.split(",").indexOf("" + id ) === 0) {
                    selectVedio = selectVedio.replace(id + ',' , '');
                } else {
                    selectVedio = selectVedio.replace(',' + id , '');
                }
            } else {
                selectVedio = '';
            }
        }

        var str = '';

        if(selectVedio !== "" && selectVedio.split(",").length > 0) {
            document.getElementById(id).remove();
            $('input[name={{$config->get("id")}}_vimeo_ids]').val(selectVedio);
        } else if(selectVedio === '') {
            document.getElementById('selectVideoInfo').innerHTML = '';
            str = `
               <tr>
                    <td colspan="2" style="padding-top:14.5px; padding-bottom:14.5px;">선택된 영상이 없습니다</td>
               </tr>
            `;
            document.getElementById('selectVideoInfo').innerHTML = str;
            $('input[name={{$config->get("id")}}_vimeo_ids]').val('');
        }
    }
    function getDirectoryList() {
        XE.ajax({
            type: 'post',
            dataType: 'json',
            url: '{{route('manage.dynamic_field_extend.getSelectDirectoryList')}}',
            success: function (response) {
                document.getElementById('vimeoList').innerHTML = '';
                let directoryData = response.data;
                var str = '';
                for(let i in directoryData){
                    str += `
                    <tr onclick="selectDirectory(${directoryData[i].id}, '${directoryData[i].name}')">
                        <td>${directoryData[i].name}</td>
                        <td>폴더</td>
                        <td>${directoryData[i].created_at}</td>
                    </tr>
                    `;
                }
                document.getElementById('vimeoList').innerHTML = str;
                document.getElementById('selectDirectory').innerText = '';
            }
        });
    }
</script>
