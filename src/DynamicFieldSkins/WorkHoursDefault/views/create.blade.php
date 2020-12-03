<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $config->get('id') }}">{{ xe_trans($config->get('label')) }}</label>

    @if ($config->get('skinDescription') !== '')
        <small>{{ $config->get('skinDescription') }}</small>
    @endif
    {{--{{date("y-m-d H-i-s",time())}}{{date("y-m-d H-i-s",time())}}--}}
    {{--<div class="xu-form-group__box">--}}
        {{--<input type="text" name="{{ $key['column'] }}"--}}
               {{--class="xe-form-control xu-form-group__control __xe_df __xe_df_text __xe_df_text_{{ $config->get('id') }}" value=""--}}
               {{--data-valid-name="{{ xe_trans($config->get('label')) }}"--}}
               {{--placeholder="{{ xe_trans($config->get('placeholder', '')) }}" />--}}
    {{--</div>--}}

    {{--{{xe_trans($config->get('label'))}}--}}

    <div class="xu-form-group__box">
        <label>Mon</label>
        <div style="width: 100%">
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                <option value="Closed">휴무</option>
                @for($i=0; $i<13; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
            <label style="float: left;">:</label>
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                @for($i=0; $i<60; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
            <label style="float: left;">~ </label>
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                @for($i=0; $i<13; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
            <label style="float: left;">:</label>
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                @for($i=0; $i<60; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>

            <label style="float: left;width:25px;">, </label>

            <select name="" class="xe-form-control" style="width: 80px;float: left">
                <option value="Closed">휴무</option>
                @for($i=12; $i<25; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
            <label style="float: left;">:</label>
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                @for($i=0; $i<60; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
            <label style="float: left;">~ </label>
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                @for($i=12; $i<25; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
            <label style="float: left;">:</label>
            <select name="" class="xe-form-control" style="width: 80px;float: left">
                @for($i=0; $i<60; $i++)
                    <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                @endfor
            </select>
        </div>
        <div style="clear: both"></div>
        {{--//////////////--}}

        {{--<label>Tue</label>--}}
        {{--<div style="width: 100%">--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">, </label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div style="clear: both"></div>--}}
        {{--<label>Wed</label>--}}
        {{--<div style="width: 100%">--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">, </label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div style="clear: both"></div>--}}
        {{--<label>Thu</label>--}}
        {{--<div style="width: 100%">--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">, </label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div style="clear: both"></div>--}}
        {{--<label>Fri</label>--}}
        {{--<div style="width: 100%">--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">, </label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div style="clear: both"></div>--}}
        {{--<label>Sat</label>--}}
        {{--<div style="width: 100%">--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">, </label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div style="clear: both"></div>--}}
        {{--<label>Sun</label>--}}
        {{--<div style="width: 100%">--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=0; $i<13; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">, </label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--<option value="Closed">휴무</option>--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
            {{--<label style="float: left;">-</label>--}}
            {{--<select name="" class="xe-form-control" style="width: 100px;float: left">--}}
                {{--@for($i=12; $i<25; $i++)--}}
                    {{--<option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif:00</option>--}}
                {{--@endfor--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div style="clear: both"></div>--}}
    </div>
</div>

{{--<div class="xe-form-group xe-dynamicField">--}}
    {{--<label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>--}}
    {{--@if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif--}}
    {{--<select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">--}}
        {{--<option value="">{{xe_trans($config->get('label'))}}</option>--}}
        {{--@foreach ($items as $item)--}}
            {{--<option value="{{$item->id}}">{{$item->word}}</option>--}}
        {{--@endforeach--}}
    {{--</select>--}}
{{--</div>--}}