<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <input type="text" class="form-control" id="dt_{{ $key['drp'] }}" name="dates" />
</div>

<script>
    $(document).ready(function() {
        $('#dt_{{ $key['drp'] }}').daterangepicker({
            locale: {
                autoUpdateInput: false,
                format: 'YYYY-MM-DD',
                separator: " ~ ",
                applyLabel: "적용", "cancelLabel": "취소", "fromLabel": "시작", "toLabel": "종료", "weekLabel": "주",
                daysOfWeek: ["일","월","화","수","목","금","토"],
                monthNames: ["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"]
            }
        });
    });
</script>
