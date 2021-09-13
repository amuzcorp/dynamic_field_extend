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
            <input type="text" id="{{ $key['start'] }}_start" name="{{ $key['start'] }}[]" class="xe-form-control amuz-date-picker" placeholder="{{ $config->get('date_type') == 'single' ? '날짜선택' : '시작일' }}">
        </div>
        <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; margin-bottom:10px; @if($config->get('date_type') == 'single') display:none @endif ">
            <input type="text" id="{{ $key['end'] }}_end" name="{{ $key['end'] }}[]" class="xe-form-control amuz-date-picker" placeholder="종료일">
        </div>

        <div style=" @if($config->get('picker_type') === 'date') display: none; @endif">
            <div class="xu-form-group__box"  style=" @if($config->get('time_type') != 'single')float:left; width:50%; padding-right:10px;@endif" >
                <input type="text" class="xe-form-control amuz-time-range-picker" name="{{ $key['start'] }}[]" placeholder="시작시간">
            </div>
            <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px;@if($config->get('time_type') == 'single') display:none @endif ">
                <input type="text" class="xe-form-control amuz-time-range-picker" name="{{ $key['end'] }}[]" placeholder="종료시간">
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
                defaultTime: '09:00',
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
