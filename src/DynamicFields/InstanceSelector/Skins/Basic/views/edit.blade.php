<div class="xe-form-group xe-dynamicField">
    <div>
        <div class="__xe-input-group">
            <label class="xe-label">
                <strong>{{ xe_trans($config->get('label')) }}</strong>
            </label>
            <select class="xe-form-control" name="{{ $key['iid'] }}">
                @foreach($menu_items as $id => $title)
                    <option value="{{ $id }}" @if($data['iid'] == $id) selected="selected" @endif>{{ xe_trans($title) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
</div>
