<div id="map_{{ $unique_key }}" style="width:100%;height:{{ $widgetConfig['height'] ? $widgetConfig['height'] : '350' }}px;"></div>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey={{ $widgetConfig['api_key'] }}&libraries=services"></script>
<script>
    var mapContainer_{{ $unique_key }} = document.getElementById('map_{{ $unique_key }}'), // 지도를 표시할 div
        mapOption_{{ $unique_key }} = {
            center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };

    // 지도를 생성합니다
    var map_{{ $unique_key }} = new kakao.maps.Map(mapContainer_{{ $unique_key }}, mapOption_{{ $unique_key }});

    // 주소-좌표 변환 객체를 생성합니다
    var geocoder_{{ $unique_key }} = new kakao.maps.services.Geocoder();

    // 주소로 좌표를 검색합니다
    geocoder_{{ $unique_key }}.addressSearch('{{ $widgetConfig['address'] }}', function(result, status) {

        // 정상적으로 검색이 완료됐으면
        if (status === kakao.maps.services.Status.OK) {

            var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

            // 결과값으로 받은 위치를 마커로 표시합니다
            var marker = new kakao.maps.Marker({
                map: map_{{ $unique_key }},
                position: coords
            });

            // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
            map_{{ $unique_key }}.setCenter(coords);
        }
    });
</script>
