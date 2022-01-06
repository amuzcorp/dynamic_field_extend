@php
    use Overcode\XePlugin\DynamicFactory\Components\UIObjects\TaxoSelect\TaxoSelectUIObject;
@endphp
<div class="xe-form-group xe-dynamicField">

    <input type="hidden" name="{{$config->get('id') . '_item_id'}}" value="[]" />

    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <div id="{{$config->get('id')}}_depth_categories">
        <input type="hidden" name="{{$config->get('id')}}_sub_item_count" value="0" />

        <div id="{{$config->get('id')}}_category_selected">
        </div>

        <div class="xe-dropdown __xe-dropdown-form">

            <select class="form-control" name="{{$config->get('id')}}_select_0" onchange="selectTaxonomy('{{$config->get('id')}}', this, 'first', 1)">
                <option value="0_0">카테고리를 선택해주세요</option>
                @foreach($categories as $item)
                    <option value="{{$item['value']}}_{{TaxoSelectUIObject::hasChildren($item) ? 1 : 0}}" @if(isset($value[0]) && (int) $value[0] === (int)$item['value']) selected="" @endif>{{$item['text']}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div id="{{$config->get('id')}}_depth_sub_categories">

    </div>
</div>

@include('dynamic_field_extend::src.DynamicFieldSkins.CategoryLoad.CategoryLoadDepth.views.script')
