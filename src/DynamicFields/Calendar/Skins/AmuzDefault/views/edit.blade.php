<?php
    use Carbon\Carbon;
    $start = '';
    $end = '';
    $start_time = '';
    $end_time = '';
    if($data['start']) {
        $start_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $data['start']);
        $start = $start_date_time->toDateString();
        $start_time = date('H:i', strtotime(date('Y-m-d '). $start_date_time->toTimeString()));
    }
    if($data['end']) {
        $end_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $data['end']);
        $end = $end_date_time->toDateString();
        $end_time = date('H:i', strtotime(date('Y-m-d '). $end_date_time->toTimeString()));
    }

?>

{{XeFrontend::js('assets/vendor/jqueryui/jquery-ui.min.js')->load() }}
{{XeFrontend::css('assets/vendor/jqueryui/jquery-ui.min.css')->load()}}
@if($config->get('picker_type') === 'date_time')
    {{XeFrontend::css('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css')->load()}}
    {{XeFrontend::js('/plugins/dynamic_field_extend/assets/js/dateformat.js')->load()}}
    {{XeFrontend::js('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js')->load()}}
@endif

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $key['start'] }}">{{ xe_trans($config->get('label')) }}</label>
    <div>
        <div class="xu-form-group__box" style="margin-bottom:10px; @if($config->get('date_type') != 'single') float:left; width:50%; padding-right:10px; @endif">
            <input type="text" id="{{ $key['start'] }}_start" class="xe-form-control amuz-date-picker" name="{{ $key['start'] }}[]" placeholder="{{ $config->get('date_type') == 'single' ? '날짜선택' : '시작일' }}" value="{{$start}}" >
        </div>
        <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; margin-bottom:10px; @if($config->get('date_type') == 'single') display:none @endif ">
            <input type="text" id="{{ $key['end'] }}_end" class="xe-form-control amuz-date-picker" name="{{ $key['end'] }}[]" placeholder="종료일" value="{{$end}}" >
        </div>
        <div @if($config->get('picker_type') === 'date') style="display: none;" @endif>
            <div class="xu-form-group__box"  style=" @if($config->get('time_type') != 'single')float:left; width:50%; padding-right:10px;@endif" >
                <input type="text" id="{{ $key['start'] }}_start_time" class="xe-form-control amuz-time-range-picker" name="{{ $key['start'] }}[]" placeholder="시작시간" value="{{$start_time ?: '09:00'}}" >
            </div>
            <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; @if($config->get('time_type') == 'single') display:none @endif ">
                <input type="text" id="{{ $key['start'] }}_end_time"  class="xe-form-control amuz-time-range-picker" name="{{ $key['end'] }}[]" placeholder="종료시간" value="{{$end_time ?: '09:00'}}" >
            </div>
        </div>
        <div class="clearfix" style="clear:both"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".amuz-date-picker").datepicker({
            dateFormat: "yy-mm-dd",
            prevText: '이전 달',nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true, yearSuffix: '년'
        });

        @if($config->get('picker_type') === 'date_time')
            $('.amuz-time-range-picker').timepicker({
                timeFormat: 'HH:mm',
                interval: 10,
                minTime: '00:00',
                maxTime: '23:50',
                startTime: '09:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                change: function(time) {
                }
            });
        @endif

    });
</script>
