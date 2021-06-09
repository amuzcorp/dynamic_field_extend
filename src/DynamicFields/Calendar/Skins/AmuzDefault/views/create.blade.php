{{XeFrontend::js('assets/vendor/jqueryui/jquery-ui.min.js')->load() }}
{{XeFrontend::css('assets/vendor/jqueryui/jquery-ui.min.css')->load()}}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $key['start'] }}">{{ xe_trans($config->get('label')) }}</label>
    <div>
        <div class="xu-form-group__box" style="float:left; width:50%; padding-right:10px;">
            <input type="text" id="{{ $key['start'] }}_start" name="{{ $key['start'] }}" class="xe-form-control amuz-date-picker" placeholder="{{ $config->get('date_type') == 'single' ? '날짜선택' : '시작일' }}">
        </div>
        <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; @if($config->get('date_type') == 'single') display:none @endif ">
            <input type="text" id="{{ $key['end'] }}_end" name="{{ $key['end'] }}" class="xe-form-control amuz-date-picker" placeholder="종료일">
        </div>
        <div style="clear:both"></div>
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
        /*$("#{{ $key['start'] }}_start").datepicker({
            dateFormat: "yy-mm-dd",
            prevText: '이전 달',nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true, yearSuffix: '년'
        });

        $("#{{ $key['end'] }}_end").datepicker({
            dateFormat: "yy-mm-dd",
            prevText: '이전 달',nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true, yearSuffix: '년'
        });*/
    });
</script>
