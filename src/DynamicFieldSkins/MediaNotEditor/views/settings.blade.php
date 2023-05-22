{{--<input type="text" name="skinDescription" placeholder="skin description" class="form-control" value="{{$config != null ? $config->get('skinDescription') : ''}}" />--}}
직접입력 - 구분값:표시값, 줄바꿈(Enter)으로 구별
<select name="file_only_option" class="form-control">
    <option value="all" @if($config->get('file_only_option') == 'all') selected @endif>All File</option>
    <option value="image/*" @if($config->get('file_only_option') == 'image/*') selected @endif>All Image</option>
    <option value="audio/*" @if($config->get('file_only_option') == 'audio/*') selected @endif>All Audio</option>
    <option value="video/*" @if($config->get('file_only_option') == 'video/*') selected @endif>All Video</option>
    <option value=".hex" @if($config->get('file_only_option') == '.hex') selected @endif>Hex Only</option>
    <option value=".bin" @if($config->get('file_only_option') == '.bin') selected @endif>Bin Only</option>
    <option value=".pdf" @if($config->get('file_only_option') == '.pdf') selected @endif>PDF Only</option>
    <option value=".hex,.h16,.h20,.bin" @if($config->get('file_only_option') == '.hex, .h16, .h20') selected @endif>JIG Files</option>
</select>
