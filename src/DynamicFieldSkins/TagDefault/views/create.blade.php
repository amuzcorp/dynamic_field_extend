{{--해시태그<input type="text" name="{{$config->get('id')}}_column" class="xe-form-control xu-form-group__control __xe_df __xe_df_text __xe_df_text_normal_text" value="" data-valid-name="해시태그" placeholder="해시태그를 입력해주세요.">
--}}

@if($config_dynamic->get('hash_tag') == 1)
    <div class="xe-form-group xe-dynamicField">
        <input type="hidden" name="tag_column" value="{{ $args['strTags'] }}">
        @if ($args['scriptInit'])
            {{ XeFrontend::js('plugins/dynamic_field_extend/assets/js/BoardTags.js')->appendTo('body')->load() }}
        @endif
        <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</label>
        <div id="xeBoardTagWrap" class="xe-select-label __xe-board-tag" data-tags="{{ $args['strTags'] }}"
             data-url="/editor/hashTag">
            <vue-tags-input v-model="tag" :tags="tags" @tags-changed="update" :autocomplete-items="autocompleteItems"
                            placeholder="{{xe_trans($config->get('placeholder',''))}}"></vue-tags-input>
        </div>

        <style>
            .xe-select-label {
                height: 60px;
            }

            .__xe-board-tag .vue-tags-input .ti-input {
                max-width: 100%;
            }

            .ti-input[data-v-61d92e31] {
                border: none !important;
                height: 55px;
            }

            .vue-tags-input[data-v-61d92e31] {
                max-width: none;
                line-height: 60px;
                border-bottom: 1px solid #e0e0e0;
            }

            .ti-tag.ti-invalid[data-v-61d92e31], .ti-tag.ti-tag.ti-deletion-mark[data-v-61d92e31] {
                background-color: rgba(0, 0, 0, 0.8);
                border-radius: 3px;
            }

            .ti-new-tag-input-wrapper input[data-v-61d92e31]::placeholder {
                font-size: 14px;
                line-height: 25px;
                letter-spacing: -0.2px;
            }

            .ti-new-tag-input-wrapper input[data-v-61d92e31] {
                font-size: 18px;
            }
        </style>
    </div>
@endif
