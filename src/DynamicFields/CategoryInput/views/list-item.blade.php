
    @foreach($data as $key => $json_obj)
        @if($json_obj != null)
        <div class="{{ $key }}">
            @php $category_field_items = json_dec($json_obj); @endphp
            @foreach($category_field_items as $category_field_item)
                <span class="xe-badge btn-default">{{ $category_field_item }}</span>
            @endforeach
        </div>
        @endif
    @endforeach
