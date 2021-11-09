
    @foreach($data as $key => $json_obj)
        @if($json_obj != null)
        <div class="{{ $key }}">
            @php $category_field_items = json_dec($json_obj); @endphp
            @if(is_array($category_field_items) == true)
                @foreach($category_field_items as $category_field_item)
                    <span class="xe-badge btn-default">{{ $category_field_item }}</span>
                @endforeach
            @else
                {{$category_field_items}}
            @endif
        </div>
        @endif
    @endforeach
