{{XeFrontend::css('plugins/dynamic_field_extend/assets/style.css')->load()}}

<div class="xe-form-group xe-dynamicField">
    <input type="hidden" id="{{$config->get('id')}}_location_data" name="{{$config->get('id')}}_location_data[]"
           value="">
    <input type="hidden" id="{{$config->get('id')}}_location_info" name="{{$config->get('id')}}_location_info[]"
           value="">
    <input type="hidden" id="{{$config->get('id')}}_zoom_level" name="{{$config->get('id')}}_zoom_level"
           value="{{$args[$config->get('id')."_zoom_level"]}}">
    <input type="hidden" id="{{$config->get('id')}}_auto_center" name="{{$config->get('id')}}_auto_center"
           value="{{$args[$config->get('id')."_auto_center"]}}">
    <input type="hidden" id="{{$config->get('id')}}_center_location" name="{{$config->get('id')}}_center_location"
           value="{{$args[$config->get('id')."_center_location"]}}">
    <input type="hidden" id="{{$config->get('id')}}_list_display" name="{{$config->get('id')}}_list_display"
           value="{{$args[$config->get('id')."_list_display"]}}">

    <div class="xe-btn-toggle" style="display: none">
        <label>
            <span class="sr-only">중앙자동지정</span><br>
            <input type="checkbox" id="{{$config->get('id')}}_auto_set" name="{{$config->get('id')}}_auto_set"
                   onchange="{{$config->get('id')}}_auto_chk()"
                   @if($args[$config->get('id')."_auto_center"] == "true") checked @endif>
            <span class="toggle"></span>
        </label>
    </div>
    <div class="xe-btn-toggle" style="display: none">
        <label>
            <span class="sr-only">리스트 표시</span><br>
            <input type="checkbox" id="{{$config->get('id')}}_list_display_chk"
                   name="{{$config->get('id')}}_list_display_chk" onchange="{{$config->get('id')}}_list_chk()"
                   @if($args[$config->get('id')."_list_display"] == "true") checked @endif>
            <span class="toggle"></span>
        </label>
    </div>
    <br>
    <script>
        function {{$config->get('id')}}_list_chk() {
            //alert(document.getElementById("{{$config->get('id')}}_list_display_chk").checked);
            document.getElementById("{{$config->get('id')}}_list_display").value = document.getElementById("{{$config->get('id')}}_list_display_chk").checked;
        }

        {{$config->get('id')}}_list_chk();
    </script>
    <div class="{{$config->get('id')}}_auto_settings" style="display: none">
        <span>확대레벨(수치가 클수록 가까워집니다.) :</span>
        <input type="text" id="{{$config->get('id')}}_zoom" name="{{$config->get('id')}}_zoom_level"
               value="{{$args[$config->get('id').'_zoom_level']}}" style="width:30px"><br>
        <span>중앙위치지정(마우스로 지도 위치를 클릭하면 지정됩니다.)</span>
        <input type="text" id="{{$config->get('id')}}_center_val" name="{{$config->get('id')}}_center_location"
               value="{{$args[$config->get('id').'_center_location']}}" style="width: 400px">
        <br>
    </div>

    <div class="map" id="map"
         style="@if($args[$config->get('id')."_list_display"] == "true")width:70%@else width:100% @endif;height:400px;float:left;@if(json_decode($args[$config->get('id')."_location_data"]) == null) display: none; @elseif(!array_filter(json_decode($args[$config->get('id')."_location_data"]))) display: none; @endif"></div>
    <div class="store-list" id="{{$config->get('id')}}_store_list"
         style="width:28%;height:400px;overflow:auto;float:left;@if($args[$config->get('id')."_list_display"] != "true") display:none;@endif">
        <div class="row_map">
            @if(isset($args[$config->get('id')."_location_data"]))
                @foreach(json_decode($args[$config->get('id')."_location_data"]) as $location)
                    @if($location)
                        @php
                            $location_array = json_decode($location,true);
                        @endphp
                        @if($args[$config->get('id')."_list_display"] == "true")
                            <div class="col">
                                <div class="store-item">
                                    <div>
                                        <h3 class="store-item-title" style="float:left">{{$location_array[0]}}</h3>
                                        <button type="button" style="display: none"
                                                class="store-item-del xe-btn xi-trash-o"
                                                onclick="{{$config->get('id')}}_list_del(this,'{{json_decode($location,true)[4]}}','{{json_decode($location,true)[5]}}')"
                                                style="float:right"></button>
                                    </div>
                                    <div style="clear: both"></div>
                                    <span class="address-field">{{$location_array[1]}} {{$location_array[2]}}</span>
                                    <div class="btn_area">
                                        <a class="store-btn xi-call"
                                           href="tel:+82{{$location_array[3]}}">{{$location_array[3]}}</a>
                                        <a class="store-btn xi-maker"
                                           href="javascript:{{$config->get('id')}}_setCenter('{{$location_array[4]}}', '{{$location_array[5]}}')">위치보기</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <input type="hidden" name="{{$config->get('id')}}_location_data[]" value="{{$location}}">
                        <input type="hidden" name="{{$config->get('id')}}_location_info[]"
                               value="{{ json_decode($args[$config->get('id')."_location_info"])[$loop->index]}}">
                    @endif
                @endforeach
            @endif
        </div>
    </div>


    <div id="input_addr" style="width:250px;height:400px;overflow:auto;display: none">
        <div>
            <p>위치 제목을 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_title"
                   id="{{$config->get('id')}}_addr_title" value=""><br>
            <p>위치 주소를 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_text"
                   id="{{$config->get('id')}}_addr_text" value=""><br>
            <p>나머지 주소를 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_text_ex"
                   id="{{$config->get('id')}}_addr_text_ex" value=""><br>
            <p>연락처를 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_phone"
                   id="{{$config->get('id')}}_addr_phone" value=""><br>
            <p>마우스를 올리면 표시될 내용입니다.</p>
            <textarea class="xe-form-control" name="{{$config->get('id')}}_addr_sign"
                      id="{{$config->get('id')}}_addr_sign" value=""></textarea><br>
        </div>

        <button class="xe-btn" type="button" onclick="{{$config->get('id')}}_searchAddressToCoordinate()">위치추가</button>
    </div>

    <div style="clear: both"></div>
</div>

<script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ $map_key }}&submodules=geocoder"></script>

<script>

    var {{$config->get('id')}}_map = new naver.maps.Map("map", {
        center: new naver.maps.LatLng(37.3595316, 127.1052133),
        zoom: 11,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: naver.maps.MapTypeControlStyle.BUTTON,
            position: naver.maps.Position.TOP_RIGHT
        },
        zoomControl: true,
        zoomControlOptions: {
            style: naver.maps.ZoomControlStyle.SMALL,
            position: naver.maps.Position.RIGHT_CENTER
        },
        scaleControl: true,
        scaleControlOptions: {
            position: naver.maps.Position.BOTTOM_RIGHT
        },
        logoControl: true,
        logoControlOptions: {
            position: naver.maps.Position.TOP_LEFT
        },
        mapDataControl: true,
        mapDataControlOptions: {
            position: naver.maps.Position.BOTTOM_LEFT
        }
    });

    var {{$config->get('id')}}_infoWindow = new naver.maps.InfoWindow({
        anchorSkew: true
    });

    {{$config->get('id')}}_map.setCursor('pointer');

    var {{$config->get('id')}}_markers = [];

    var {{$config->get('id')}}_location_data = document.querySelectorAll("input[type=hidden][name='{{$config->get('id')}}_location_data[]']");
    var {{$config->get('id')}}_location_info_content = document.querySelectorAll("input[type=hidden][name='{{$config->get('id')}}_location_info[]']");

    var once_chk = true;

    for (var i = 0; i < {{$config->get('id')}}_location_data.length; i++) {
        if ({{$config->get('id')}}_location_data[i].value) {
            var my_data = JSON.parse({{$config->get('id')}}_location_data[i].value);
            {{$config->get('id')}}_manual_mark_add(my_data[1], {{$config->get('id')}}_location_info_content[i].value);
            //append_list_manual(my_data[0],my_data[1],my_data[2],my_data[3],my_data[4],my_data[5], my_data[1]);
        }
    }

    function {{$config->get('id')}}_manual_mark_add(address, info) {
        //var my_addr_array = addr;
        //var addr_name = info;


        naver.maps.Service.geocode({
            query: address
        }, function (status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                if (!address) {
                    return alert('Geocode Error, Please check address');
                }
                return alert('Geocode Error, address:' + address);
            }

            if (response.v2.meta.totalCount === 0) {
                return alert('No result.');
            }

            var htmlAddresses = [],
                item = response.v2.addresses[0],
                point = new naver.maps.Point(item.x, item.y);

            {{$config->get('id')}}_addMarker_load(point, info);

            {{--{{$config->get('id')}}_map.setCenter(point);--}}

        });
    }


    // 마커를 생성하고 지도위에 표시하는 함수입니다
    function {{$config->get('id')}}_addMarker(position, info) {

        // 마커를 생성합니다
        var marker = new naver.maps.Marker({
            position: position,
            map: {{$config->get('id')}}_map
        });


        var double_chk = true;
        var marker_lat = marker.getPosition().x;
        var marker_lng = marker.getPosition().y;

        for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {// 이미 등록됐는지 체크
            if (({{$config->get('id')}}_markers[i].getPosition().x == marker_lat) && ({{$config->get('id')}}_markers[i].getPosition().y == marker_lng)) {
                if ({{$config->get('id')}}_markers[i].getMap()) {
                    double_chk = false;
                }
            }
        }

        if (double_chk) {
            if ({{$config->get('id')}}_append_list(marker_lat, marker_lng)) {//리스트 추가, 입력창 체크
                // 마커가 지도 위에 표시되도록 설정합니다
                {{--marker.setMap({{$config->get('id')}}_map);--}}
                marker.setPosition(position);
                {{$config->get('id')}}_map.setCenter(position);//마커의 중앙으로 이동
                {{$config->get('id')}}_map.setZoom(17);


                // 생성된 마커를 배열에 추가합니다
                {{$config->get('id')}}_markers.push(marker);

                var info_str = "";
                if (info) {
                    info_str = info.replace(/(?:\r\n|\r|\n)/g, '<br/>');
                } else {
                    info_str = "";
                }


                var my_info = infoWin_return(info_str);
                naver.maps.Event.addListener(marker, "mouseover", {{$config->get('id')}}_makeOverListener({{$config->get('id')}}_map, marker, my_info));
                naver.maps.Event.addListener(marker, "mouseout", {{$config->get('id')}}_makeOutListener(my_info));


                {{--{{$config->get('id')}}_infowindows.push(infowindow);--}}


                {{--//{{$config->get('id')}}_append_list(marker.getPosition().getLat(), marker.getPosition().getLng());--}}

                {{$config->get('id')}}_center_auto_apply(position);

            }
        } else {
            alert("이미 등록된 장소입니다.");
        }
    }

    // 페이지 로드시 마커 추가
    function {{$config->get('id')}}_addMarker_load(position, info) {

        // 마커를 생성합니다
        var marker = new naver.maps.Marker({
            position: position,
            map: {{$config->get('id')}}_map
        });


        var double_chk = true;
        var marker_lat = marker.getPosition().x;
        var marker_lng = marker.getPosition().y;

        for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {// 이미 등록됐는지 체크
            if (({{$config->get('id')}}_markers[i].getPosition().x == marker_lat) && ({{$config->get('id')}}_markers[i].getPosition().y == marker_lng)) {
                if ({{$config->get('id')}}_markers[i].getMap()) {
                    double_chk = false;
                }
            }
        }

        if (double_chk) {
            {{--if ({{$config->get('id')}}_append_list(marker_lat, marker_lng)) {//리스트 추가, 입력창 체크--}}
            if (true) {
                // 마커가 지도 위에 표시되도록 설정합니다
                {{--marker.setMap({{$config->get('id')}}_map);--}}
                marker.setPosition(position);
                {{$config->get('id')}}_map.setCenter(position);//마커의 중앙으로 이동
                {{$config->get('id')}}_map.setZoom(17);


                // 생성된 마커를 배열에 추가합니다
                {{$config->get('id')}}_markers.push(marker);

                var info_str = "";
                if (info) {
                    info_str = info.replace(/(?:\r\n|\r|\n)/g, '<br/>');
                } else {
                    info_str = "";
                }


                var my_info = infoWin_return(info_str);
                naver.maps.Event.addListener(marker, "mouseover", {{$config->get('id')}}_makeOverListener({{$config->get('id')}}_map, marker, my_info));
                naver.maps.Event.addListener(marker, "mouseout", {{$config->get('id')}}_makeOutListener(my_info));


                {{--{{$config->get('id')}}_infowindows.push(infowindow);--}}


                {{--//{{$config->get('id')}}_append_list(marker.getPosition().getLat(), marker.getPosition().getLng());--}}

                {{$config->get('id')}}_center_auto_apply(position);

            }
        } else {
            alert("이미 등록된 장소입니다.");
        }
    }

    // 인포윈도우를 표시하는 클로저를 만드는 함수입니다
    function {{$config->get('id')}}_makeOverListener(map, marker, infowindow) {
        return function () {
            infowindow.open(map, marker);
        };
    }

    // 인포윈도우를 닫는 클로저를 만드는 함수입니다
    function {{$config->get('id')}}_makeOutListener(infowindow) {
        return function () {
            infowindow.close();
        };
    }

    function {{$config->get('id')}}_delMarker(my_marker) {
        for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {
            if ({{$config->get('id')}}_markers[i] == my_marker) {
                {{$config->get('id')}}_markers[i].setMap(null);
                {{--{{$config->get('id')}}_infowindows[i].close();--}}
            }
        }

    }


    function {{$config->get('id')}}_searchAddressToCoordinate() {
        var address = document.getElementById("{{$config->get('id')}}_addr_text").value;

        naver.maps.Service.geocode({
            query: address
        }, function (status, response) {
            if (status === naver.maps.Service.Status.ERROR) {
                if (!address) {
                    return alert('Geocode Error, Please check address');
                }
                return alert('Geocode Error, address:' + address);
            }

            if (response.v2.meta.totalCount === 0) {
                return alert('No result.');
            }

            var htmlAddresses = [],
                item = response.v2.addresses[0],
                point = new naver.maps.Point(item.x, item.y);

            {{$config->get('id')}}_addMarker(point, document.getElementById("{{$config->get('id')}}_addr_sign").value);

            {{--{{$config->get('id')}}_map.setCenter(point);--}}

        });
    }

    function infoWin_return(str) {

        var infoWindow = new naver.maps.InfoWindow({
            anchorSkew: true
        });

        infoWindow.setContent([
            '<div style="padding:10px;min-width:100px;line-height:150%;">',
            '<h4 style="margin-top:5px;">' + str + '</h4><br />' +
            '</div>'
        ].join('\n'));

        {{--{{$config->get('id')}}_infoWindow.open({{$config->get('id')}}_map, point);--}}

            return infoWindow;
    }


    function {{$config->get('id')}}_initGeocoder() {
        if (!{{$config->get('id')}}_map.isStyleMapReady) {
            return;
        }

        {{$config->get('id')}}_map.addListener('click', function (e) {
            // alert(e.coord.x+","+e.coord.y);
            if (!{{$config->get('id')}}_center_auto_set()) {
                document.getElementById("{{$config->get('id')}}_center_val").value = e.coord.x + "," + e.coord.y;
                {{$config->get('id')}}_map.setCenter(e.coord);
            }
        });
    }

    function {{$config->get('id')}}_append_list(lat, lng) {
                {{--{{$config->get('id')}}_store_list--}}
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
        div_str += '<div ><h3 class="store-item-title" style="float:left">' + title + '</h3>';
        div_str += '<button type="button" class="store-item-del xe-btn xi-trash-o" onclick="{{$config->get('id')}}_list_del(this, ' + lat + ',' + lng + ')" style="float:right"  ></button></div><br>';
        div_str += '<span class="address-field">' + addr + ' ' + addr_ex + '</span>';
        div_str += '<div class="btn_area"><a class="store-btn xi-call" href="tel:+82' + phone + '">' + phone + '</a>';
        //div_str+='<a href="#" class="store-btn xi-maker">위치보기</a></div>';
        div_str += ' <a class="store-btn xi-maker" href="javascript:' + '{{$config->get("id")}}' + '_setCenter(' + lat + ',' + lng + ')" >위치보기</a>';
        div_str += '</div>';
        div_str += '<input type="hidden" name="{{$config->get('id')}}_location_data[]" value=\'{"0":"' + title + '", "1":"' + addr + '", "2":"' + addr_ex + '", "3":"' + phone + '", "4":"' + lat + '", "5":"' + lng + '"}\'>';
        {{--div_str+='<input type="hidden" name="{{$config->get('id')}}_location_data[]" value=\'{"'+title+'","'+addr+'","'+addr_ex+'","'+phone+'",'+lat+','+lng+'}\'>';--}}
            div_str += '<input type="hidden" name="{{$config->get('id')}}_location_info[]" value="' + detail + '">';
        div.innerHTML = div_str;
        if (title) {
            list_child[1].appendChild(div);
            title_chk = true;
        } else {
            alert("제목 내용이 있어야 리스트에 추가됩니다.");
            title_chk = false;
        }

        return title_chk;
        //console.log(list_child[1]);
    }

    function {{$config->get('id')}}_list_del(my_col, lat, lng) {
        for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {
            if (({{$config->get('id')}}_markers[i].getPosition().x == lat) && ({{$config->get('id')}}_markers[i].getPosition().y == lng)) {
                {{$config->get('id')}}_markers[i].setMap(null);
                {{--{{$config->get('id')}}_infowindows[i].close();--}}
                {{--document.getElementById("{{$config->get('id')}}_location_data").value = JSON.stringify(positions);--}}
                {{--document.getElementById("{{$config->get('id')}}_location_info").value = JSON.stringify({{$config->get('id')}}_infowindows);--}}
            }
        }

        {{$config->get('id')}}_auto_chk();

        my_col.parentNode.parentNode.parentNode.remove();
    }

    function {{$config->get('id')}}_auto_chk() {
        var my_display = document.querySelector('.{{$config->get('id')}}_auto_settings').style.display;
        if ({{$config->get('id')}}_center_auto_set() && my_display == "block") {
            document.querySelector('.{{$config->get('id')}}_auto_settings').style.display = "none";
        } else if (my_display == "none") {
            document.querySelector('.{{$config->get('id')}}_auto_settings').style.display = "block";
        }

        if ({{$config->get('id')}}_center_auto_set()) {


            var now_markers = [];
            //======중앙 자동 지정 데이터 저장
            for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {
                if ({{$config->get('id')}}_markers[i].getMap()) {
                    now_markers.push({{$config->get('id')}}_markers[i]);
                }
            }

            if (now_markers.length) {
                var my_bounds_cnt = [];
                {{$config->get('id')}}_map.setCenter(now_markers[0].getPosition());
                {{$config->get('id')}}_map.setZoom(17);
                var my_bounds = now_markers[0].getMap().getBounds();
                for (var j = 1; j < now_markers.length; j++) {
                    my_bounds_cnt.push(my_bounds.extend(now_markers[j].getPosition()));
                }


                //======중앙 자동 지정 데이터 저장end
                //======중앙 자동 지정
                if (my_bounds_cnt.length) {
                    {{$config->get('id')}}_map.fitBounds(my_bounds);

                } else {

                }
            }

        }
    }

    function {{$config->get('id')}}_now_center_auto_set() {
        document.getElementById("{{$config->get('id')}}_auto_center").value = document.getElementById('{{$config->get('id')}}_auto_set').checked;
        if (document.getElementById("{{$config->get('id')}}_auto_center").value == "true") {
            document.querySelector(".{{$config->get('id')}}_auto_settings").style.display = "none";
        }
    }

    {{$config->get('id')}}_now_center_auto_set();


    function {{$config->get('id')}}_center_auto_set() {
        document.getElementById("{{$config->get('id')}}_auto_center").value = document.getElementById("{{$config->get('id')}}_auto_set").checked;
        return document.getElementById("{{$config->get('id')}}_auto_set").checked;
    }

    function {{$config->get('id')}}_center_auto_apply(position) {
        if ({{$config->get('id')}}_center_auto_set()) {


                    {{--var my_bounds_cnt = [];--}}
                    {{--var default_bounds = {{$config->get('id')}}_map.getBounds();--}}
                    {{--var my_bounds = naver.maps.LatLngBounds.bounds(default_bounds.getSW(), default_bounds.getNE());--}}
                    {{--//console.log(default_bounds.getSW());--}}
                    {{--var cnt = 0;--}}
                    {{--//======중앙 자동 지정 데이터 저장--}}
                    {{--for (i = 0; i < {{$config->get('id')}}_markers.length; i++) {--}}
                    {{--if ({{$config->get('id')}}_markers[i].getMap()) {--}}
                    {{--my_bounds_cnt.push(my_bounds.extend({{$config->get('id')}}_markers[i].getPosition()));--}}
                    {{--}--}}
                    {{--}--}}

                    {{--//======중앙 자동 지정 데이터 저장end--}}
                    {{--//======중앙 자동 지정--}}
                    {{--if(my_bounds_cnt.length){--}}
                    {{--{{$config->get('id')}}_map.setBounds({{$config->get('id')}}_bounds);--}}
                    {{--{{$config->get('id')}}_map.fitBounds(my_bounds);--}}
                    {{--{{$config->get('id')}}_map.fitBounds(my_bounds, { top: 50, right: 50, bottom: 50, left: 50 });--}}

                    {{--}--}}

            var now_markers = [];
            //======중앙 자동 지정 데이터 저장
            for (var i = 0; i < {{$config->get('id')}}_markers.length; i++) {
                if ({{$config->get('id')}}_markers[i].getMap()) {
                    now_markers.push({{$config->get('id')}}_markers[i]);
                }
            }

            if (now_markers.length) {
                var my_bounds_cnt = [];
                {{$config->get('id')}}_map.setCenter(now_markers[0].getPosition());
                {{$config->get('id')}}_map.setZoom(17);
                var my_bounds = now_markers[0].getMap().getBounds();
                for (var j = 1; j < now_markers.length; j++) {
                    my_bounds_cnt.push(my_bounds.extend(now_markers[j].getPosition()));
                }


                //======중앙 자동 지정 데이터 저장end
                //======중앙 자동 지정
                if (my_bounds_cnt.length) {
                    {{$config->get('id')}}_map.fitBounds(my_bounds);

                } else {

                }
            }

        } else {

            var center = document.getElementById("{{$config->get('id')}}_center_location").value.split(",");
            if (center.length > 1) {
                var coords = new naver.maps.LatLng(center[0], center[1]);

                //마커 수동 중앙 지정
                {{$config->get('id')}}_map.setCenter(coords);
                {{$config->get('id')}}_map.setZoom({{$args[$config->get('id').'_zoom_level']}});
                //마커 수동 중앙 지정end
            }
        }
    }

    function {{$config->get('id')}}_setCenter(lat, lng) {
        // 이동할 위도 경도 위치를 생성합니다
        var moveLatLon = new naver.maps.Point(lat, lng);

        // 지도 중심을 이동 시킵니다
        {{$config->get('id')}}_map.setCenter(moveLatLon);
    }

    {{--naver.maps.onJSContentLoaded = {{$config->get('id')}}_initGeocoder;--}}
    naver.maps.Event.once({{$config->get('id')}}_map, 'init_stylemap', {{$config->get('id')}}_initGeocoder);
</script>


