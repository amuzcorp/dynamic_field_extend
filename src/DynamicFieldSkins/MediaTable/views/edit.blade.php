@php
use Xpressengine\MediaLibrary\Models\MediaLibraryFile;
@endphp
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
    <input type="hidden" name="_column" value="dum">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <div>
        <button type="button" class="xe-btn" onclick=media_popup("{{$config->get('id')}}")><i class="xi-plus"></i> 미디어
            라이브러리
        </button>
    </div>
    <ul class="thumb_{{$config->get('id')}} media_meta_table" id="thumb_{{$config->get('id')}}" style="padding-left: 0px;">
        <input type="hidden" name="{{$config->get('id').'_column'}}" id="{{$config->get('id').'_column'}}"
               value="{{json_encode($media)}}">
        @if(isset($media) && $media != 'null')
            @foreach($media as $data)
                @if($img = XeStorage::find($data))
                    @php
                    $meta = MediaLibraryFile::where('file_id',$data)->first();
                    @endphp
                    <li>
                        <input type="hidden" name="{{$config->get('id')."_column[]"}}" class="{{$data}}"
                               value="{{$data}}">
                        <div class="row">
                            <div class="col-sm-3">
                                <img width=100px height=100px alt="alt_text" src="{{$storage_path.'/'.$img->path.'/'.$img->filename}}">
                            </div>
                            <div class="col-sm-9">
                                <a href="#" class="pull-right" onclick="media_del(jQuery(this).parent().parent().parent()); return false"><i class="xi-close"></i></a>
                                <h4>{{ $meta->title }}</h4>
                                <h5>{{ $meta->description }}</h5>
                                <p>{{ $meta->caption }}</p>
                            </div>
                        </div>
                    </li>
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
</script>
