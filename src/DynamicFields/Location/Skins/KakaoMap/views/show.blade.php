{{ XeFrontend::js('//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js')->load() }}
{{ XeFrontend::js('//dapi.kakao.com/v2/maps/sdk.js?appkey='. $map_key .'&libraries=services')->appendTo('head')->load() }}

<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_address __xe_df_address_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    <div id="map_{{ $config->get('id') }}" style="width:100%;height:300px;"></div>
    <span>
        {{ $data['doro'] }} (지번 주소 : {{ $data['jibun'] }})
        {{ $data['detail'] }}
    </span>
</div>


<script>
    var mapContainer_{{ $config->get('id') }} = document.getElementById('map_{{ $config->get('id') }}'), // 지도를 표시할 div
        mapOption_{{ $config->get('id') }} = {
            center: new kakao.maps.LatLng({{ $data['lat'] }}, {{ $data['lng'] }}), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };

    // 지도를 생성합니다
    var map_{{ $config->get('id') }} = new kakao.maps.Map(mapContainer_{{ $config->get('id') }}, mapOption_{{ $config->get('id') }});

    // 주소-좌표 변환 객체를 생성합니다
    var geocoder_{{ $config->get('id') }} = new kakao.maps.services.Geocoder();

    // 지도를 클릭한 위치에 표출할 마커입니다
    var marker_{{ $config->get('id') }} = new kakao.maps.Marker({
        // 지도 중심좌표에 마커를 생성합니다
        position: map_{{ $config->get('id') }}.getCenter()
    });
    // 지도에 마커를 표시합니다
    marker_{{ $config->get('id') }}.setMap(map_{{ $config->get('id') }});
</script>
