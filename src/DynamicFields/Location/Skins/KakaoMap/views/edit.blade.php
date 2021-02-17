{{ XeFrontend::js('//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js')->load() }}
{{ XeFrontend::js('//dapi.kakao.com/v2/maps/sdk.js?appkey='. $map_key .'&libraries=services')->appendTo('head')->load() }}

<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_address __xe_df_address_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <div class="xe-form-inline">
        <input type="text" name="{{$key['postcode']}}" id="postcode_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="우편번호" readonly="readonly" value="{{$data['postcode']}}">
        <input type="button" class="xe-btn xe-btn-default" onclick="execDaumPostcode_{{$config->get('id')}}()" value="우편번호 찾기">
    </div>
    <div class="xe-form-inline">
        <input type="text" name="{{$key['doro']}}" id="doro_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="도로명주소" readonly="readonly" value="{{$data['doro']}}">
        <input type="text" name="{{$key['jibun']}}" id="jibun_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="지번주소" readonly="readonly" value="{{$data['jibun']}}">
        <input type="text" name="{{$key['detail']}}" id="detail_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="상세주소" value="{{$data['detail']}}">
        {{--        <input type="text" id="extra_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="참고항목" readonly="readonly">--}}
        <span id="guide_{{$config->get('id')}}" style="color:#999;display:none"></span>
    </div>
    <div class="xe-form-inline">
        <input type="text" name="{{$key['lat']}}" id="lat_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="위도" readonly="readonly" value="{{$data['lat']}}">
        <input type="text" name="{{$key['lng']}}" id="lng_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="경도" readonly="readonly" value="{{$data['lng']}}">
        <span style="color:#666; font-size:0.9em;">* 지도를 클릭하여 핀 위치를 변경 할 수 있습니다.</span>
    </div>
</div>

<div id="map_{{ $config->get('id') }}" style="width:100%;height:300px;"></div>

<script type="text/javascript">
    function execDaumPostcode_{{$config->get('id')}}() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById("postcode_{{$config->get('id')}}").value = data.zonecode;
                document.getElementById("doro_{{$config->get('id')}}").value = roadAddr;
                document.getElementById("jibun_{{$config->get('id')}}").value = data.jibunAddress;

                // 참고항목 문자열이 있을 경우 해당 필드에 넣는다.
                /*if(roadAddr !== ''){
                    document.getElementById("extra_{{$config->get('id')}}").value = extraRoadAddr;
                } else {
                    document.getElementById("extra_{{$config->get('id')}}").value = '';
                }*/

                var guideTextBox = document.getElementById("guide_{{$config->get('id')}}");
                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                    guideTextBox.style.display = 'block';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                    guideTextBox.style.display = 'block';
                } else {
                    guideTextBox.innerHTML = '';
                    guideTextBox.style.display = 'none';
                }

                a2c(roadAddr);
            }
        }).open();
    }

    var mapContainer_{{ $config->get('id') }} = document.getElementById('map_{{ $config->get('id') }}'), // 지도를 표시할 div
        mapOption_{{ $config->get('id') }} = {
            center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
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

    // 지도에 클릭 이벤트를 등록합니다
    // 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
    kakao.maps.event.addListener(map_{{ $config->get('id') }}, 'click', function(mouseEvent) {

        // 클릭한 위도, 경도 정보를 가져옵니다
        var latlng = mouseEvent.latLng;

        $('#lat_{{$config->get('id')}}').val(latlng.getLat());
        $('#lng_{{$config->get('id')}}').val(latlng.getLng());

        // 마커 위치를 클릭한 위치로 옮깁니다
        marker_{{ $config->get('id') }}.setPosition(latlng);
    });

    // Address To Coordinate
    function a2c(address){
        // 주소로 좌표를 검색합니다
        if(address) {
            geocoder_{{ $config->get('id') }}.addressSearch(address, function (result, status) {
                // 정상적으로 검색이 완료됐으면
                if (status === kakao.maps.services.Status.OK) {

                    var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                    $('#lat_{{$config->get('id')}}').val(result[0].y);
                    $('#lng_{{$config->get('id')}}').val(result[0].x);

                    // 마커 위치를 옮깁니다
                    marker_{{ $config->get('id') }}.setPosition(coords);

                    // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                    map_{{ $config->get('id') }}.setCenter(coords);
                }
            });
        }
    }

    function locationReload(){
        let lat = "{{$data['lat']}}";
        let lng = "{{$data['lng']}}";
        if(lat != '' && lng != ''){
            let coords = new kakao.maps.LatLng(lat, lng);
            marker_{{ $config->get('id') }}.setPosition(coords);
            map_{{ $config->get('id') }}.setCenter(coords);
        }else{
            a2c(document.getElementById("doro_{{$config->get('id')}}").value);
        }
    }

    $(document).ready(function() {
        locationReload();
    });
</script>
