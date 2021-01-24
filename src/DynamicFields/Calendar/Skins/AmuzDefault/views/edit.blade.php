{{XeFrontend::js('https://code.jquery.com/ui/1.12.1/jquery-ui.js')->appendTo('head')->load() }}
{{XeFrontend::css('http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css')->load()}}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $key['ca'] }}">{{ xe_trans($config->get('label')) }}</label>
    <div>
        <div class="xu-form-group__box" style="float:left; width:50%; padding-right:10px;">
            <input type="text" id="{{ $key['ca'] }}_start" name="{{ $key['ca'] }}[]" class="xe-form-control" placeholder="시작일">
        </div>
        <div class="xu-form-group__box" style="float:right; width:50%; padding-left:10px; @if($config->get('date_type') == 'single') display:none @endif ">
            <input type="text" id="{{ $key['ca'] }}_end" name="{{ $key['ca'] }}[]" class="xe-form-control" placeholder="종료일">
        </div>
        <div style="clear:both"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#{{ $key['ca'] }}_start").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: 0,
        });

        $("#{{ $key['ca'] }}_end").datepicker({
            dateFormat: "yy-mm-dd",
        });
    });
</script>
