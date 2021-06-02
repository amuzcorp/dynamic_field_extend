
<td class="dayname_{{$week}}">
    <div class="form-group xe-form-group form-inline xe-form-inline">
        <label class="">
            <input data-target="{{$config->get('id')}}_{{$week}}[{{$time}}" name="{{$config->get('id')}}_{{$week}}[pause_{{$time}}]" type="checkbox" class="form-control" checked="checked" />
            휴무
        </label>
        @foreach(['start','end'] as $type)
            @if($type == 'end') <span class="input-group-addon">~</span> @endif
            <select name="{{$config->get('id')}}_{{$week}}[{{$time}}_{{$type}}_hour]" class="form-control xe-form-control" style="width:80px;" disabled="disabled">
                @for($i=0; $i<=11; $i++) <option value="{{str_pad($i,2,0)}}">{{str_pad($i,2,0)}}</option> @endfor
            </select> :
            <select name="{{$config->get('id')}}_{{$week}}[{{$time}}_{{$type}}_minute]" class="form-control xe-form-control" style="width:80px;" disabled="disabled">
                @for($i=0; $i<=59; $i++) <option value="{{str_pad($i,2,0)}}">{{str_pad($i,2,0)}}</option> @endfor
            </select>
        @endforeach
    </div>
</td>
