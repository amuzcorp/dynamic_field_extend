{{--<input type="text" name="skinDescription" placeholder="skin description" class="form-control" value="{{$config != null ? $config->get('skinDescription') : ''}}" />--}}
직접입력 - 구분값:표시값, 줄바꿈(Enter)으로 구별
<textarea name="category_contents" class="form-control" style="height: 100px">{{$config != null ? $config->get('category_contents') : ''}}</textarea>