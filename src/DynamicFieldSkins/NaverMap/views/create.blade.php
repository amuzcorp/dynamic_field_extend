{{XeFrontend::css('plugins/dynamic_field_extend/assets/style.css')->load()}}
<div class="xe-form-group xe-dynamicField">
    <h class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_basic">{{xe_trans($config->get('label'))}}</h>
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{$map_key}}&submodules=geocoder"></script>

    <input type="hidden" id="{{$config->get('id')}}_location_info" name="{{$config->get('id')}}_location_info[]"
           value="">
    <input type="hidden" id="{{$config->get('id')}}_auto_center" name="{{$config->get('id')}}_auto_center"
           value="false">
    <input type="hidden" id="{{$config->get('id')}}_list_display" name="{{$config->get('id')}}_list_display"
           value="true">

    <div class="xe-btn-toggle">
        <label>
            <span>중앙자동지정</span><br>
            <input type="checkbox" id="{{$config->get('id')}}_auto_set" name="{{$config->get('id')}}_auto_set"
                   onchange="{{$config->get('id')}}_auto_chk()">
            <span class="toggle"></span>
        </label>
    </div>
    <div class="xe-btn-toggle">
        <label>
            <span>리스트 표시</span><br>
            <input type="checkbox" id="{{$config->get('id')}}_list_display_chk"
                   name="{{$config->get('id')}}_list_display_chk" onchange="{{$config->get('id')}}_list_chk()" checked>
            <span class="toggle"></span>
        </label>
    </div>
    <br>
    <script>
        function {{$config->get('id')}}_list_chk() {
            //alert(document.getElementById("{{$config->get('id')}}_list_display_chk").checked);
            document.getElementById("{{$config->get('id')}}_list_display").value = document.getElementById("{{$config->get('id')}}_list_display_chk").checked;
        }
    </script>
    <div class="{{$config->get('id')}}_auto_settings" style="display: block">
        <span>확대레벨(수치가 클수록 가까워집니다.) :</span>
        <input type="text" class="zoom_level_input" id="{{$config->get('id')}}_zoom"
               name="{{$config->get('id')}}_zoom_level" value=11 style="width:30px"><br>
        <span>중앙위치지정(마우스로 지도 위치를 클릭하면 지정됩니다.)</span>
        <input type="text" class="auto_center_location_input" id="{{$config->get('id')}}_center_val"
               name="{{$config->get('id')}}_center_location" value="" autocomplete="off">
        <br>
    </div>

    {{--<div class="map" id="{{$config->get('id')}}_map" style="width:500px;height:400px;float:left"></div>--}}

    <div class="map" id="map" style="width:70%;height:400px;float:left"></div>

    <div class="store-list" id="{{$config->get('id')}}_store_list"
         style="width:28%;height:400px;overflow:auto;float:left">
        <div class="row_map">
        </div>
    </div>

<div style="clear: both"></div>
    <div id="input_addr" style="height:400px;overflow:auto">
        <div>
            <p>위치 제목을 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_title"
                   id="{{$config->get('id')}}_addr_title" value="">
            <p>위치 주소를 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_text"
                   id="{{$config->get('id')}}_addr_text" value="" autocomplete="off"
                   onkeyup="{{$config->get('id')}}_location_search(this.value)">
            <div class="{{$config->get('id')}}_location_ex location_ex_div"></div>
            <p>나머지 주소를 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_text_ex"
                   id="{{$config->get('id')}}_addr_text_ex" value="">
            <p>연락처를 입력해주세요.</p>
            <input type="text" class="xe-form-control" name="{{$config->get('id')}}_addr_phone"
                   id="{{$config->get('id')}}_addr_phone" value="">
            <p>마우스를 올리면 표시될 내용입니다.</p>
            <textarea class="xe-form-control" name="{{$config->get('id')}}_addr_sign"
                      id="{{$config->get('id')}}_addr_sign" value=""></textarea>
        </div>

        <div class="add_list_btn">
            <button class="xe-btn" type="button" onclick="{{$config->get('id')}}_searchAddressToCoordinate()">위치추가
            </button>
            {{--<button type="button" onclick="{{$config->get('id')}}_mark_init()">초기화</button>--}}
        </div>
    </div>

    <div style="clear: both"></div>
</div>
<script>


    var {{$config->get('id')}}_map = new naver.maps.Map("map", {
        center: new naver.maps.LatLng(37.3595316, 127.1052133),
        zoom: 11,
        mapTypeControl: true
    });

    var {{$config->get('id')}}_infoWindow = new naver.maps.InfoWindow({
        anchorSkew: true
    });

    {{$config->get('id')}}_map.setCursor('pointer');

    var {{$config->get('id')}}_markers = [];


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

            console.log(response);
            if (response.v2.meta.totalCount === 0) {
                return alert('No result.');
            }

            var htmlAddresses = [],
                item = response.v2.addresses[0],
                point = new naver.maps.Point(item.x, item.y);

            {{$config->get('id')}}_addMarker(point, document.getElementById("{{$config->get('id')}}_addr_sign").value);

            if (item.roadAddress) {
                htmlAddresses.push('[도로명 주소] ' + item.roadAddress);
            }

            if (item.jibunAddress) {
                htmlAddresses.push('[지번 주소] ' + item.jibunAddress);
            }

            if (item.englishAddress) {
                htmlAddresses.push('[영문명 주소] ' + item.englishAddress);
            }

            {{$config->get('id')}}_infoWindow.setContent([
                '<div style="padding:10px;min-width:100px;line-height:150%;">',
                '<h4 style="margin-top:5px;">검색 주소 : ' + address + '</h4><br />',
                htmlAddresses.join('<br />'),
                '</div>'
            ].join('\n'));

            {{--{{$config->get('id')}}_infoWindow.open({{$config->get('id')}}_map, point);--}}

            {{--{{$config->get('id')}}_map.setCenter(point);--}}

        });
    }

    function {{$config->get('id')}}_location_search(my_text) {

        var address = my_text;

        var list_div = document.querySelector(".{{$config->get('id')}}_location_ex");

        if (my_text != "") {
            if (my_text.length > 1) {
                naver.maps.Service.geocode({
                    query: address
                }, function (status, response) {
                    if (status === naver.maps.Service.Status.ERROR) {
                        if (!address) {
                            //return alert('Geocode Error, Please check address');
                            list_div.style.display = "none";
                        }
                        //return alert('Geocode Error, address:' + address);
                        list_div.style.display = "none";
                    }

                    console.log(response.v2.addresses);
                    console.log(my_text.length);
                    if (response.v2.meta.totalCount === 0) {
                        //return alert('No result.');
                        list_div.style.display = "none";
                    } else {
                        //console.log(result[0]['address_name']);
                        var result = response.v2.addresses;
                        list_div.style.display = "block";
                        list_div.innerHTML = "";

                        for (var k = 0; k < result.length; k++) {
                            var p = document.createElement('p');
                            var result_name = result[k]['roadAddress'];
                            {{$config->get('id')}}_addClickProxy(p, result_name);
                            p.append(result_name);
                            list_div.appendChild(p);
                        }
                    }

                });
            }
        }
    }

    function {{$config->get('id')}}_addClickProxy(element, result_name) {
        var currentOnClick = element.onclick;
        var list_div = document.querySelector(".{{$config->get('id')}}_location_ex");
        element.onclick = function () {
            if (currentOnClick) {
                currentOnClick();
            }
            document.getElementById("{{$config->get('id')}}_addr_text").value = result_name;
            list_div.style.display = "none";
        }
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
                document.getElementById("{{$config->get('id')}}_center_val").value = e.coord.y + "," + e.coord.x;
                {{$config->get('id')}}_map.setCenter(e.coord);
                {{$config->get('id')}}_map.setZoom(document.getElementById("{{$config->get('id').'_zoom'}}").value);
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
            {{--{{$config->get('id')}}_map.fitBounds(my_bounds, { top: 50, right: 50, bottom: 50, left: 50 });--}}
            {{--{{$config->get('id')}}_map.fitBounds(my_bounds);--}}

            {{--}--}}
        }
    }

    function {{$config->get('id')}}_center_auto_set() {
        document.getElementById("{{$config->get('id')}}_auto_center").value = document.getElementById("{{$config->get('id')}}_auto_set").checked;
        return document.getElementById("{{$config->get('id')}}_auto_set").checked;
    }

    function {{$config->get('id')}}_center_auto_apply(position) {
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

        } else {
            //마커 수동 중앙 지정
            {{$config->get('id')}}_map.setCenter(position);
            {{$config->get('id')}}_map.setZoom(document.getElementById("{{$config->get('id')}}_zoom").value);
            //마커 수동 중앙 지정end
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


