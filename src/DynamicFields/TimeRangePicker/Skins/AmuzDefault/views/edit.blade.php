{{ XeFrontend::css('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css')->load() }}
{{ XeFrontend::js('/plugins/dynamic_field_extend/assets/js/dateformat.js')->load() }}
{{ XeFrontend::js('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js')->load() }}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $key['start'] }}">{{ xe_trans($config->get('label')) }}</label>
    <div>
        <div class="xu-form-group__box" style="float:left; width:50%; padding-right:10px;">
            <input type="text" id="trp_{{ $key['start'] }}_start" name="{{ $key['start'] }}" class="xe-form-control" placeholder="{{ $config->get('date_type') == 'single' ? '날짜선택' : '시작일' }}" value="{{ $data['start'] }}">
        </div>
        <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; @if($config->get('time_type') == 'single') display:none @endif ">
            <input type="text" id="trp_{{ $key['end'] }}_end" name="{{ $key['end'] }}" class="xe-form-control" placeholder="종료시간" value="{{ $data['end'] }}">
        </div>
        <div style="clear:both"></div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#trp_{{ $key['start'] }}_start').timepicker({
            timeFormat: 'HH:mm',
            interval: 10,
            minTime: '00:00',
            maxTime: '23:50',
            defaultTime: '{{ $data['start'] }}',
            startTime: '09:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            change: function(time) {
                {{--
                let end = $('#trp_{{ $key['trp'] }}_end').val();
                end = end.replaceAll(':','');
                let start = time.format('HHmm');

                if(start > end) {
                    let end_time = new Date();
                    end_time.setHours(end.substring(0, 2) - 1);
                    end_time.setMinutes(end.substring(2));

                    $('#trp_{{ $key['trp'] }}_start').val(end_time.format('HH:mm'));

                    alert('시작시간은 종료시간보다 작아야 합니다.');
                }
                --}}
            }
        });
        $('#trp_{{ $key['end'] }}_end').timepicker({
            timeFormat: 'HH:mm',
            interval: 10,
            minTime: '00:00',
            maxTime: '23:50',
            defaultTime: '{{ $data['end'] }}',
            startTime: '09:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            change: function(time) {
                {{--
                let start = $('#trp_{{ $key['trp'] }}_start').val();
                start = start.replaceAll(':','');
                let end = time.format('HHmm');

                if(start > end) {
                    let start_time = new Date();
                    start_time.setHours(end.substring(0, 2) + 1);
                    start_time.setMinutes(end.substring(2));

                    $('#trp_{{ $key['trp'] }}_end').val(start_time.format('HH:mm'));

                    alert('시작시간은 종료시간보다 작아야 합니다.');
                }
                --}}
            }
        });
    });
</script>
