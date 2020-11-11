{{XeFrontend::js('plugins/dynamic_field/assets/js/jquery.edittable.min.js')->appendTo('head')->load() }}
{{XeFrontend::css('plugins/dynamic_field/assets/jquery.edittable.min.css')->load()}}

<div>
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
    <div>
        <textarea id="{{$config->get('id')."_table"}}" style="display:none" name="{{$config->get('id').'_column'}}" readonly>
            {{$args[$config->get('id').'_column']}}
        </textarea>

        <script>
            $(window).ready(function () {
                $('#{{$config->get("id")."_table"}}').editTable(
                    {
                        first_row:true,
                    }
                );

                $('.inputtable input').attr('readonly',true);

            });


        </script>


    </div>
</div>

<style>
    table.inputtable td:last-child, table.inputtable th:last-child
    {
        display: none;
    }

    table.inputtable thead
    {
        display: none;
    }

    /*table.inputtable.wh tbody tr:nth-child(1), table.inputtable.wh tbody tr:nth-child(1) input*/
    /*{*/
        /*background: #f1f1f1;*/
        /*border-color:#ddd;*/
    /*}*/

</style>