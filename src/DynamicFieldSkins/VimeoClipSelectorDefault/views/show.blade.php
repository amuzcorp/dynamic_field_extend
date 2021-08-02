<style>
    #vimeoVideoContent iframe {
        width: 100% !important;
        height: auto !important;
        min-height: 350px !important;
    }
</style>
<div class="row">
    @foreach($datas as $data)
        <div class="col-12">
            <label>
                {{$data->name}}
            </label>
            <button class="btn btn-info" onclick="viewVideoData({{$data->id}})">영상보기</button>
            <button class="btn btn-danger" onclick="removeVideo()">닫기</button>
        </div>
    @endforeach
</div>
<div style="width:100%;">
    <div id="vimeoVideoContent"></div>
</div>

<script>
    function viewVideoData(id) {
        let access_token = '{{$config->get('access_token')}}';

        let params = {
            id : id,
            access_token: access_token
        };
        XE.ajax({
            type: 'post',
            dataType: 'json',
            data: params,
            url: '{{route('dynamic_field_extend.vimeo.getVideoInfo')}}',
            success: function (response) {
                document.getElementById('vimeoVideoContent').innerHTML = '';
                document.getElementById('vimeoVideoContent').innerHTML = response.data.embed.html;
            }
        });
    }
    function removeVideo() {
        document.getElementById('vimeoVideoContent').innerHTML = '';
    }
</script>
