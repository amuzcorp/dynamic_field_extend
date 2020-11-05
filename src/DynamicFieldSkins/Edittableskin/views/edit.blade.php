{{XeFrontend::js('plugins/dynamic_field_extend/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field_extend/assets/jquery.edittable.min.css')->load()}}

<div>
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>

    <div>
        <textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id')."_column"}}" >
            {{$args[$config->get('id').'_column']}}
        </textarea>

        <script>
            $(window).ready(function () {
                $('#{{$config->get("id")."_table"}}').editTable();
            });

        </script>


    </div>
</div>