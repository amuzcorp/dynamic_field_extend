<div class="col-md-2">
    <label class="form-label">{{xe_trans($config->get('label'))}}</label>
</div>
<div class="col-md">
    <input type="text" class="form-control" name="{{$key['cell_phone_number']}}" value="{{$data['cell_phone_number']}}" data-valid-name="{{ xe_trans($config->get('label')) }}"
           @if ($config->get('placeholder', '') != '') placeholder="{{xe_trans($config->get('placeholder'))}}" @endif />
</div>
