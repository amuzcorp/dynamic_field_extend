@php
    use Overcode\XePlugin\DynamicFactory\Components\UIObjects\TaxoSelect\TaxoSelectUIObject;
@endphp


<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id') . '_item_id'}}" value="{{$data['item_id']}}" />
    <label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif

    <div id="{{$config->get('id')}}_depth_categories">
        <input type="hidden" name="{{$config->get('id')}}_sub_item_count" value="{{count($selectedItemCollection) > 0 ? count($selectedItemCollection) : 0}}" />

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
        @php $index = 1; @endphp
        @foreach($sub_categories as $key => $sub_item)
            @if(count($sub_item) !== 0)
                <div id="{{$config->get('id')}}_{{$index}}_form">
                    <label>{{xe_trans($selectedItemCollection[$key]->word)}}</label>
                    <div class="xe-dropdown __xe-dropdown-form">
                        <select class="form-control" name="{{$config->get('id')}}_select_{{$index}}" onchange="selectTaxonomy('{{$config->get('id')}}', this, 'sub', {{$index + 1}})">
                            <option value="0_0">{{xe_trans($selectedItemCollection[$key]->word)}} 카테고리를 선택해주세요</option>
                            @foreach($sub_item as $s_item)
                                <option value="{{$s_item->id}}_{{$s_item->child === true ? 1 : 0}}" @if(in_array((string) $s_item->id, $value)) selected @endif>{{xe_trans($s_item->word)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @php $index += 1; @endphp
            @endif
        @endforeach
    </div>
</div>

@include('dynamic_field_extend::src.DynamicFieldSkins.CategoryLoad.CategoryLoadDepth.views.script')
