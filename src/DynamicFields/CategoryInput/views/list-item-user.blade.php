
    @foreach($data as $key => $json_obj)
        @if($json_obj != null)
        <div class="{{ $key }}">
            @php $category_field_items = json_dec($json_obj); @endphp
            <span class="xe-badge btn-default">{{ $category_field_items->display_name }}</span>
        </div>
        @endif
    @endforeach
