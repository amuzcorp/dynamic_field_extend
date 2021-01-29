{{XeFrontend::js('https://code.jquery.com/ui/1.12.1/jquery-ui.js')->appendTo('head')->load() }}
{{XeFrontend::css('http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css')->load()}}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $key['ca'] }}">{{ xe_trans($config->get('label')) }}</label>
    <div>
        <div class="xu-form-group__box" style="float:left; width:50%; padding-right:10px;">
            @if(count($values) > 0)
            <input type="text" id="{{ $key['ca'] }}_start" name="{{ $key['ca'] }}[]" class="xe-form-control" placeholder="시작일" value="{{ $values[0] }}">
            @else
            <input type="text" id="{{ $key['ca'] }}_start" name="{{ $key['ca'] }}[]" class="xe-form-control" placeholder="시작일">
            @endif
        </div>
        <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; @if($config->get('date_type') == 'single') display:none @endif ">
            @if(count($values) > 1)
            <input type="text" id="{{ $key['ca'] }}_end" name="{{ $key['ca'] }}[]" class="xe-form-control" placeholder="종료일" value="{{ $values[1] }}">
            @else
            <input type="text" id="{{ $key['ca'] }}_end" name="{{ $key['ca'] }}[]" class="xe-form-control" placeholder="종료일">
            @endif
        </div>
        <div style="clear:both"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#{{ $key['ca'] }}_start").datepicker({
            dateFormat: "yy-mm-dd",
            prevText: '이전 달',nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true, yearSuffix: '년'
        });

        $("#{{ $key['ca'] }}_end").datepicker({
            dateFormat: "yy-mm-dd",
            prevText: '이전 달',nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true, yearSuffix: '년'
        });
    });
</script>
