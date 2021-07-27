<span class="xe-badge xe-btn-primary-outline">{{ $data[$id . '_postcode']  }}</span>
@if(array_get($data,$id . '_doro') != null)
<p>{{ explode(" ",$data[$id . '_doro'])[0] }} {{ explode(" ",$data[$id . '_doro'])[1] }} {{ explode(" ",$data[$id . '_doro'])[2] }}</p>
@else
<p class="text-muted">입력되지 않은 주소</p>
@endif
