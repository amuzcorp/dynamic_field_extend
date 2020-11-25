{{XeFrontend::css('plugins/dynamic_field_extend/assets/style.css')->load()}}
<!DOCTYPE html>
{{--광주광역시 서구 치평동 시청로--}}
{{--제주특별자치도 제주시 첨단로 242--}}
{{--부산광역시 연제구 연산동 중앙대로 1001--}}
{{--중구 세종대로 110 서울특별시청--}}
<html>
<head>
    {{--<meta charset="utf-8"/>--}}
    {{--<title>Kakao 지도 시작하기</title>--}}
    <h class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</h><br>
</head>
<body>
<input type="hidden" id="{{$config->get('id')}}_location_data" name="{{$config->get('id')}}_location_data[]" value="">
<input type="hidden" id="{{$config->get('id')}}_location_info" name="{{$config->get('id')}}_location_info[]" value="">
<input type="hidden" id="{{$config->get('id')}}_zoom_level" name="{{$config->get('id')}}_zoom_level" value="{{$args[$config->get('id')."_zoom_level"]}}">
<input type="hidden" id="{{$config->get('id')}}_auto_center" name="{{$config->get('id')}}_auto_center" value="{{$args[$config->get('id')."_auto_center"]}}">
<input type="hidden" id="{{$config->get('id')}}_center_location" name="{{$config->get('id')}}_center_location" value="{{$args[$config->get('id')."_center_location"]}}">
<input type="hidden" id="{{$config->get('id')}}_list_display" name="{{$config->get('id')}}_list_display" value="{{$args[$config->get('id')."_list_display"]}}">

<div class="xe-btn-toggle">
<label>
<span class="sr-only">중앙자동지정</span><br>
    <input type="checkbox" id="{{$config->get('id')}}_auto_set" name="{{$config->get('id')}}_auto_set" onchange="{{$config->get('id')}}_auto_chk()"  @if($args[$config->get('id')."_auto_center"] == "true") checked @endif>
<span class="toggle"></span>
</label>
</div>

<div class="xe-btn-toggle">
<label>
<span class="sr-only">리스트 표시</span><br>
    <input type="checkbox" id="{{$config->get('id')}}_list_display_chk" name="{{$config->get('id')}}_list_display_chk" onchange="{{$config->get('id')}}_list_chk()" @if($args[$config->get('id')."_list_display"] == "true") checked @endif>
<span class="toggle"></span>
</label>
</div>
<br>
<script>
    function {{$config->get('id')}}_list_chk() {
        //alert(document.getElementById("{{$config->get('id')}}_list_display_chk").checked);
        document.getElementById("{{$config->get('id')}}_list_display").value=document.getElementById("{{$config->get('id')}}_list_display_chk").checked;
    }
    {{$config->get('id')}}_list_chk();
</script>
<div class="{{$config->get('id')}}_auto_settings" style="display: block">
    <span>확대레벨(수치가 클수록 멀어집니다.) :</span>
    <input type="text" id="{{$config->get('id')}}_my_zoom" name="{{$config->get('id')}}_zoom_level" value="{{$args[$config->get('id').'_zoom_level']}}" style="width:30px"><br>
    <span>중앙위치지정(마우스로 지도 위치를 클릭하면 지정됩니다.)</span>
    <input type="text" id="{{$config->get('id')}}_center_val" name="{{$config->get('id')}}_center_location" value="{{$args[$config->get('id').'_center_location']}}" style="width: 400px">
    <br>
</div>

    <div class="map" id="{{$config->get('id')}}_map" style="width:500px;height:400px;float:left"></div>
    <div class="store-list" id="{{$config->get('id')}}_store_list" style="width:250px;height:400px;overflow:auto;float:left">

    <div class="row_map">
        {{--<div class="col">--}}
        {{--<div class="store-item">--}}
        {{--<div class="store-item-title">제목</div>--}}
        {{--<span class="address-field">주소</span>--}}
        {{--<div class="btn_area">--}}
        {{--<a class="store-btn" href="tel:+82#">연락처</a>--}}
        {{--<a href="#">위치보기</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

        @foreach(json_decode($args[$config->get('id')."_location_data"]) as $location)
            @if($location)
                @php
                    $location_array = json_decode($location,true);
                @endphp
                    <div class="col">
                        <div class="store-item">
                            <div>
                                <h3 class="store-item-title" style="float:left">{{$location_array[0]}}</h3>
                                <button type="button" class="store-item-del xe-btn xi-trash-o" onclick="{{$config->get('id')}}_list_del(this,'{{json_decode($location,true)[4]}}','{{json_decode($location,true)[5]}}')" style="float:right"></button>
                            </div><div style="clear: both"></div>
                            <span class="address-field">{{$location_array[1]}} {{$location_array[2]}}</span>
                            <div class="btn_area">
                                <a class="store-btn xi-call" href="tel:+82{{$location_array[3]}}">{{$location_array[3]}}</a>
                                <a class="store-btn xi-maker" href="javascript:{{$config->get('id')}}_setCenter('{{$location_array[4]}}', '{{$location_array[5]}}')" >위치보기</a>
                            </div>
                        </div>
                        <input type="hidden" name="{{$config->get('id')}}_location_data[]" value="{{$location}}">
                        <input type="hidden" name="{{$config->get('id')}}_location_info[]" value="{{ json_decode($args[$config->get('id')."_location_info"])[$loop->index]}}">
                    </div>
            @endif
        @endforeach
    </div>
</div>



<div id="input_addr" style="width:250px;height:400px;overflow:auto">
    <div>
        <p>위치 제목을 입력해주세요.</p>
        <input type="text" name="{{$config->get('id')}}_addr_title" id="{{$config->get('id')}}_addr_title" value=""><br>
        <p>위치 주소를 입력해주세요.</p>
        <input type="text" name="{{$config->get('id')}}_addr_text" id="{{$config->get('id')}}_addr_text" value="부산 남구 용호4동 533-16"><br>
        <p>나머지 주소를 입력해주세요.</p>
        <input type="text" name="{{$config->get('id')}}_addr_text_ex" id="{{$config->get('id')}}_addr_text_ex" value=""><br>
        <p>연락처를 입력해주세요.</p>
        <input type="text" name="{{$config->get('id')}}_addr_phone" id="{{$config->get('id')}}_addr_phone" value=""><br>
        <p>마우스를 올리면 표시될 내용입니다.</p>
        <textarea  name="{{$config->get('id')}}_addr_sign" id="{{$config->get('id')}}_addr_sign" value=""></textarea><br>
    </div>
    <button class="xe-btn" type="button" onclick="{{$config->get('id')}}_search_marks()">위치추가</button>
</div>

{{--<button type="button" onclick="{{$config->get('id')}}_mark_init()">초기화</button>--}}
<div style="clear: both"></div>
</body>
</html>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey={{$map_key}}&libraries=services"></script>
<script>


    var {{$config->get('id')}}_mapContainer = document.getElementById('{{$config->get('id')}}_map'), // 지도를 표시할 div
        mapOption = {
            center: new kakao.maps.LatLng(35.17956183396675, 129.0750633652598), // 지도의 중심좌표
            level: 6 // 지도의 확대 레벨
        };

    var {{$config->get('id')}}_map = new kakao.maps.Map({{$config->get('id')}}_mapContainer, mapOption); // 지도를 생성합니다

    // 주소-좌표 변환 객체를 생성합니다
    var geocoder = new kakao.maps.services.Geocoder();


    // 지도를 재설정할 범위정보를 가지고 있을 LatLngBounds 객체를 생성합니다
    var {{$config->get('id')}}_bounds = new kakao.maps.LatLngBounds();


    // 지도를 클릭했을때 클릭한 위치에 마커를 추가하도록 지도에 클릭이벤트를 등록합니다
    kakao.maps.event.addListener({{$config->get('id')}}_map, 'click', function(mouseEvent) {
        // 클릭한 위치에 마커를 표시합니다
        //{{$config->get('id')}}_addMarker(mouseEvent.latLng);
        if(!{{$config->get('id')}}_center_auto_set()) {
            {{$config->get('id')}}_map.setCenter(mouseEvent.latLng);
            {{$config->get('id')}}_map.setLevel(document.getElementById("{{$config->get('id')}}_my_zoom").value);
            //document.getElementById("center_val").value = mouseEvent.latLng;
            document.getElementById("{{$config->get('id')}}_center_val").value = mouseEvent.latLng.getLat()+","+mouseEvent.latLng.getLng();
        }
    });

    // 지도에 표시된 마커 객체를 가지고 있을 배열입니다
    var {{$config->get('id')}}_markers = [];
    var {{$config->get('id')}}_infowindows = [];

    // 마커 하나를 지도위에 표시합니다
    //addMarker(new kakao.maps.LatLng(33.450701, 126.570667));

    var {{$config->get('id')}}_location_data = document.querySelectorAll("input[type=hidden][name='{{$config->get('id')}}_location_data[]']");
    var {{$config->get('id')}}_location_info_content = document.querySelectorAll("input[type=hidden][name='{{$config->get('id')}}_location_info[]']");
    for(var i=0; i<{{$config->get('id')}}_location_data.length; i++){
        if({{$config->get('id')}}_location_data[i].value) {
            var my_data = JSON.parse({{$config->get('id')}}_location_data[i].value);
            {{$config->get('id')}}_manual_mark_add(my_data[1], {{$config->get('id')}}_location_info_content[i].value);
            //append_list_manual(my_data[0],my_data[1],my_data[2],my_data[3],my_data[4],my_data[5], my_data[1]);
        }
    }

    function {{$config->get('id')}}_mark_init() {
        {{$config->get('id')}}_markers = [];
        {{$config->get('id')}}_infowindows = [];
        mapOption = {
            center: new kakao.maps.LatLng(35.17956183396675, 129.0750633652598), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };
        {{$config->get('id')}}_map = new kakao.maps.Map({{$config->get('id')}}_mapContainer, mapOption); // 지도를 생성합니다
        {{$config->get('id')}}_bounds = new kakao.maps.LatLngBounds();

        // 지도를 클릭했을때 클릭한 위치에 마커를 추가하도록 지도에 클릭이벤트를 등록합니다
        kakao.maps.event.addListener({{$config->get('id')}}_map, 'click', function(mouseEvent) {
            // 클릭한 위치에 마커를 표시합니다
            if(!{{$config->get('id')}}_center_auto_set()) {
                {{$config->get('id')}}_map.setCenter(mouseEvent.latLng);
                {{$config->get('id')}}_map.setLevel(document.getElementById("{{$config->get('id')}}_my_zoom").value);
                //document.getElementById("center_val").value = mouseEvent.latLng;
                document.getElementById("{{$config->get('id')}}_center_val").value = mouseEvent.latLng.getLat()+","+mouseEvent.latLng.getLng();
            }
        });
    }

    // 마커를 생성하고 지도위에 표시하는 함수입니다
    function {{$config->get('id')}}_addMarker(position, info) {

        // 마커를 생성합니다
        var marker = new kakao.maps.Marker({
            position: position
        });

        var double_chk = true;
        var marker_lat = marker.getPosition().getLat();
        var marker_lng = marker.getPosition().getLng();

        for(var i=0; i<{{$config->get('id')}}_markers.length; i++ ){// 이미 등록됐는지 체크
            if(({{$config->get('id')}}_markers[i].getPosition().getLat() == marker_lat) && ({{$config->get('id')}}_markers[i].getPosition().getLng() == marker_lng)) {
                if({{$config->get('id')}}_markers[i].getMap()) {
                    double_chk = false;
                }
            }
        }


        if (double_chk) {
            if({{$config->get('id')}}_append_list(marker_lat, marker_lng)) {//리스트 추가, 입력창 체크
                // 마커가 지도 위에 표시되도록 설정합니다
                marker.setMap({{$config->get('id')}}_map);

                // 생성된 마커를 배열에 추가합니다
                {{$config->get('id')}}_markers.push(marker);

                var info_str = "";
                if (info) {
                    info_str = info.replace(/(?:\r\n|\r|\n)/g, '<br/>');
                } else {
                    info_str = "";
                }
                // 마커에 표시할 인포윈도우를 생성합니다
                var infowindow = new kakao.maps.InfoWindow({
                    content: "<div>" + info_str + "</div>" // 인포윈도우에 표시할 내용
                });

                {{$config->get('id')}}_infowindows.push(infowindow);


                {{$config->get('id')}}_center_auto_apply(position);

                kakao.maps.event.addListener(marker, 'click', {{$config->get('id')}}_makeClickListener(marker));
                kakao.maps.event.addListener(marker, 'mouseover', {{$config->get('id')}}_makeOverListener({{$config->get('id')}}_map, marker, infowindow));
                kakao.maps.event.addListener(marker, 'mouseout', {{$config->get('id')}}_makeOutListener(infowindow));
            }
        } else {
            alert("이미 등록된 장소입니다.");
        }

    }

    // 불러온 데이터에서 마커를 추가
    function {{$config->get('id')}}_addMarker_load(position, info) {

        // 마커를 생성합니다
        var marker = new kakao.maps.Marker({
            position: position
        });

        var double_chk = true;

        if(double_chk) {
            // 마커가 지도 위에 표시되도록 설정합니다
            marker.setMap({{$config->get('id')}}_map);

            // 생성된 마커를 배열에 추가합니다
            {{$config->get('id')}}_markers.push(marker);

            var info_str = "";
            if (info) {
                info_str = info.replace(/(?:\r\n|\r|\n)/g, '<br/>');
            } else {
                info_str = "";
            }
            // 마커에 표시할 인포윈도우를 생성합니다
            var infowindow = new kakao.maps.InfoWindow({
                content: "<div>" + info_str + "</div>" // 인포윈도우에 표시할 내용
            });

            {{$config->get('id')}}_infowindows.push(infowindow);


            //append_list(marker.getPosition().getLat(), marker.getPosition().getLng());

            {{$config->get('id')}}_center_auto_apply(position);

            kakao.maps.event.addListener(marker, 'click', {{$config->get('id')}}_makeClickListener(marker));
            kakao.maps.event.addListener(marker, 'mouseover', {{$config->get('id')}}_makeOverListener({{$config->get('id')}}_map, marker, infowindow));
            kakao.maps.event.addListener(marker, 'mouseout', {{$config->get('id')}}_makeOutListener(infowindow));
        }
    }

    function {{$config->get('id')}}_now_center_auto_set() {
        document.getElementById("{{$config->get('id')}}_auto_center").value = document.getElementById('{{$config->get('id')}}_auto_set').checked;
        if(document.getElementById("{{$config->get('id')}}_auto_center").value == "true"){
            document.querySelector(".{{$config->get('id')}}_auto_settings").style.display = "none";
        }
    }
    {{$config->get('id')}}_now_center_auto_set();

    function {{$config->get('id')}}_center_auto_set() {
        {{$config->get('id')}}_now_center_auto_set();
        return document.getElementById('{{$config->get('id')}}_auto_set').checked;
    }


    function {{$config->get('id')}}_center_auto_apply(position) {
        if("{{$args[$config->get('id').'_auto_center']}}" == "true") {

            {{$config->get('id')}}_bounds = new kakao.maps.LatLngBounds();
            var my_bounds = [];
            //======중앙 자동 지정 데이터 저장
            for (i = 0; i < {{$config->get('id')}}_markers.length; i++) {
                if({{$config->get('id')}}_markers[i].getMap()) {
                    my_bounds.push({{$config->get('id')}}_bounds.extend({{$config->get('id')}}_markers[i].getPosition()));
                }
            }
            //======중앙 자동 지정 데이터 저장end
            //======중앙 자동 지정
            //console.log(my_bounds.length);
            if(my_bounds.length){
                {{$config->get('id')}}_map.setBounds({{$config->get('id')}}_bounds);
            }
            //======중앙 자동 지정 end
        }else {
            var center = document.getElementById("{{$config->get('id')}}_center_location").value.split(",");
            coords = new kakao.maps.LatLng(center[0], center[1]);
            //마커 수동 중앙 지정
            {{$config->get('id')}}_map.setCenter(coords);
            {{$config->get('id')}}_map.setLevel({{$args[$config->get('id').'_zoom_level']}});
            //마커 수동 중앙 지정end
        }
    }

    // 마커 클릭작동하는 클로저를 만드는 함수
    function {{$config->get('id')}}_makeClickListener(my_marker) {
        return function() {
            {{$config->get('id')}}_delMarker(my_marker);
            {{$config->get('id')}}_center_auto_apply();
        };
    }

    // 인포윈도우를 표시하는 클로저를 만드는 함수입니다
    function {{$config->get('id')}}_makeOverListener(map, marker, infowindow) {
        return function() {
            infowindow.open(map, marker);
        };
    }

    // 인포윈도우를 닫는 클로저를 만드는 함수입니다
    function {{$config->get('id')}}_makeOutListener(infowindow) {
        return function() {
            infowindow.close();
        };
    }

    function {{$config->get('id')}}_delMarker(my_marker) {
        for(var i=0; i<{{$config->get('id')}}_markers.length; i++ ){
            if({{$config->get('id')}}_markers[i] == my_marker) {
                {{$config->get('id')}}_markers[i].setMap(null);
                {{$config->get('id')}}_infowindows[i].close();
            }
        }
    }


    // 배열에 추가된 마커들을 지도에 표시하거나 삭제하는 함수입니다
    function setMarkers(map) {
        for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {
            {{$config->get('id')}}_markers[i].setMap(map);
        }
    }

    // "마커 보이기" 버튼을 클릭하면 호출되어 배열에 추가된 마커를 지도에 표시하는 함수입니다
    function showMarkers() {
        setMarkers({{$config->get('id')}}_map)
    }

    // "마커 감추기" 버튼을 클릭하면 호출되어 배열에 추가된 마커를 지도에서 삭제하는 함수입니다
    function hideMarkers() {
        setMarkers(null);
    }

    function {{$config->get('id')}}_getAddr(){
        var my_array = document.querySelector("input[name={{$config->get('id')}}_addr_text]").value;

        return my_array;
    }

    function {{$config->get('id')}}_search_marks() {

        var my_addr_array = {{$config->get('id')}}_getAddr();
        var addr_name = document.getElementById("{{$config->get('id')}}_addr_sign").value;


        var coords = [];


        // 주소로 좌표를 검색합니다
        geocoder.addressSearch(my_addr_array, function (result, status) {
            // 정상적으로 검색이 완료됐으면
            if (status === kakao.maps.services.Status.OK) {
                coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                {{$config->get('id')}}_addMarker(coords, addr_name);
            } else {
                alert("주소의 정보를 찾지 못했습니다.");
            }
        });
    }

    function {{$config->get('id')}}_manual_mark_add(addr, info) {
        var my_addr_array = addr;
        var addr_name = info;


        var coords = [];


        // 주소로 좌표를 검색합니다
        geocoder.addressSearch(my_addr_array, function (result, status) {
            // 정상적으로 검색이 완료됐으면
            if (status === kakao.maps.services.Status.OK) {
                coords = new kakao.maps.LatLng(result[0].y, result[0].x);
                {{$config->get('id')}}_addMarker_load(coords, addr_name);
            } else {
                alert("주소의 정보를 찾지 못했습니다.");
            }
        });
    }

    function {{$config->get('id')}}_append_list(lat, lng) {
        var list_child = document.getElementById("{{$config->get('id')}}_store_list").childNodes;

        var div = document.createElement('div');
        var title = document.getElementById('{{$config->get('id')}}_addr_title').value;
        var addr = document.getElementById('{{$config->get('id')}}_addr_text').value;
        var addr_ex = document.getElementById('{{$config->get('id')}}_addr_text_ex').value;
        var phone = document.getElementById('{{$config->get('id')}}_addr_phone').value;
        var detail = document.getElementById('{{$config->get('id')}}_addr_sign').value;

        var title_chk = false;

        div.classList.add("col");
        var div_str = '<div class="store-item">';
        {{--div_str+='<div ><div class="store-item-title" style="float:left">'+title+'</div>';--}}
        {{--div_str+='<button type="button" class="store-item-del xi-trash-o" onclick="{{$config->get('id')}}_list_del(this, '+lat+','+lng+')" ></button></div>';--}}

        div_str+='<div ><h3 class="store-item-title" style="float:left">'+title+'</h3>';
        div_str+='<button type="button" class="store-item-del xe-btn xi-trash-o" onclick="{{$config->get('id')}}_list_del(this, '+lat+','+lng+')" style="float:right"  ></button></div><div style="clear: both"></div>';

        div_str+='<span class="address-field">'+addr+' '+addr_ex+'</span>';
        div_str+= '<div class="btn_area"><a class="store-btn xi-call" href="tel:+82'+phone+'">'+phone+'</a>';
        div_str+=' <a class="store-btn xi-maker" href="javascript:'+'{{$config->get("id")}}'+'_setCenter({{$location_array[4]}},{{$location_array[5]}})" >위치보기</a>';
        div_str+='</div>';
        div_str+='<input type="hidden" name="{{$config->get('id')}}_location_data[]" value=\'{"0":"'+title+'", "1":"'+addr+'", "2":"'+addr_ex+'", "3":"'+phone+'", "4":"'+lat+'", "5":"'+lng+'"}\'>';
        {{--div_str+='<input type="hidden" name="{{$config->get('id')}}_location_data[]" value=\'{"'+title+'","'+addr+'","'+addr_ex+'","'+phone+'",'+lat+','+lng+'}\'>';--}}
            div_str+='<input type="hidden" name="{{$config->get('id')}}_location_info[]" value="'+detail+'">';
        div.innerHTML = div_str;
        if(title) {
            list_child[1].appendChild(div);
            title_chk = true;
        }else{
            alert("제목 내용이 있어야 리스트에 추가됩니다.");
            title_chk = false;
        }

        return title_chk;
        //console.log(list_child[1]);
    }

    function append_list_manual(my_title,my_addr,my_addr_ex,my_phone,my_detail,lat, lng) {
        //store_list
        var list_child = document.getElementById("{{$config->get('id')}}_store_list").childNodes;

        var div = document.createElement('div');
        var title = my_title;
        var addr = my_addr;
        var addr_ex = my_addr_ex;
        var phone = my_phone;
        var detail = my_detail;

        div.classList.add("col");
        var div_str = '<div class="store-item">';
        {{--div_str+='<div ><div class="store-item-title" style="float:left">'+title+'</div>';--}}
        {{--div_str+='<button type="button" class="store-item-del xi-trash-o" onclick="{{$config->get('id')}}_list_del(this, '+lat+','+lng+')" ></button></div>';--}}

        div_str+='<div ><div class="store-item-title" style="float:left">'+title+'</div>';
        div_str+='<button type="button" class="store-item-del xe-btn xi-trash-o" onclick="{{$config->get('id')}}_list_del(this, '+lat+','+lng+')" style="float:right"  ></button></div><div style="clear: both"></div>';


        div_str+='<span class="address-field">'+addr+' '+addr_ex+'</span>';
        div_str+= '<div class="btn_area"><a class="store-btn xi-call" href="tel:+82'+phone+'">'+phone+'</a>';
        div_str+='<a href="#" class="xi-maker">위치보기</a></div>';
        div_str+='</div>';
        div_str+='<input type="hidden" name="{{$config->get('id')}}_location_data[]" value=\'{"0":"'+title+'", "1":"'+addr+'", "2":"'+addr_ex+'", "3":"'+phone+'", "4":'+lat+', "5":'+lng+'}\'>';
        {{--div_str+='<input type="hidden" name="{{$config->get('id')}}_location_data[]" value=\'{"'+title+'","'+addr+'","'+addr_ex+'","'+phone+'",'+lat+','+lng+'}\'>';--}}
            div_str+='<input type="hidden" name="{{$config->get('id')}}_location_info[]" value="'+detail+'">';
        div.innerHTML = div_str;
        list_child[1].appendChild(div);
        //console.log(list_child[1]);
    }

    function {{$config->get('id')}}_auto_chk() {
        var my_display = document.querySelector('.{{$config->get('id')}}_auto_settings').style.display;
        if({{$config->get('id')}}_center_auto_set() && my_display == "block"){
            document.querySelector('.{{$config->get('id')}}_auto_settings').style.display = "none";
        }else if(my_display=="none"){
            document.querySelector('.{{$config->get('id')}}_auto_settings').style.display = "block";
        }

        if({{$config->get('id')}}_center_auto_set()) {

            {{$config->get('id')}}_bounds = new kakao.maps.LatLngBounds();
            var my_bounds = [];
            //======중앙 자동 지정 데이터 저장
            for (i = 0; i < {{$config->get('id')}}_markers.length; i++) {
                if({{$config->get('id')}}_markers[i].getMap()) {
                    my_bounds.push({{$config->get('id')}}_bounds.extend({{$config->get('id')}}_markers[i].getPosition()));
                }
            }
            //======중앙 자동 지정 데이터 저장end
            //======중앙 자동 지정
            //console.log(my_bounds.length);
            if(my_bounds.length){
                {{$config->get('id')}}_map.setBounds({{$config->get('id')}}_bounds);
            }
            //======중앙 자동 지정 end
        }
    }

    function {{$config->get('id')}}_list_del(my_col, lat, lng) {
        for(var i=0; i<{{$config->get('id')}}_markers.length; i++ ){
            //console.log({{$config->get('id')}}_markers[i].getPosition().getLng());
            //console.log(lng);
            if(({{$config->get('id')}}_markers[i].getPosition().getLat() == lat) && ({{$config->get('id')}}_markers[i].getPosition().getLng() == lng)) {
                {{$config->get('id')}}_markers[i].setMap(null);
                {{$config->get('id')}}_infowindows[i].close();
            }
        }
        my_col.parentNode.parentNode.parentNode.remove();
    }

    function {{$config->get('id')}}_setCenter(lat, lng) {
        // 이동할 위도 경도 위치를 생성합니다
        var moveLatLon = new kakao.maps.LatLng(lat, lng);

        // 지도 중심을 이동 시킵니다
        {{$config->get('id')}}_map.setCenter(moveLatLon);
    }
</script>