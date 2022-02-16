{{ XeFrontend::js('//dapi.kakao.com/v2/maps/sdk.js?appkey='. $map_key .'&libraries=services')->appendTo('head')->load() }}

<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id')}}_currentPage" value="1"/>				<!-- 요청 변수 설정 (현재 페이지. currentPage : n > 0) -->
    <input type="hidden" name="{{$config->get('id')}}_countPerPage" value="6"/>		<!-- 요청 변수 설정 (페이지당 출력 개수. countPerPage 범위 : 0 < n <= 100) -->

    <label class="xu-form-group__label __xe_df __xe_df_address __xe_df_address_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <div class="xe-form-inline">
        <input type="text" name="{{$key['postcode']}}" id="postcode_{{$config->get('id')}}" class="xe-form-control xu-form-group__control" placeholder="우편번호" readonly="readonly" value="{{$data['postcode']}}">
        <input type="text" name="{{$config->get('id')}}_keyword" class="xe-form-control xu-form-group__control" placeholder="검색어를 입력해주세요" value=""/>
        <input type="button" class="xe-btn xe-btn-default" onclick="getAddr( '{{$address_key}}', '{{$config->get('id')}}')" value="{{xe_trans('xe::findPostCode')}}" />
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

<div id="list"> <!-- 검색 결과 리스트 출력 영역 --> </div>
<div class="paginate" id="pageApi"></div>

<div id="map_{{ $config->get('id') }}" style="width:100%;height:300px;"></div>

<script type="text/javascript">

    // 주소 검색후 데이터 받아오기
    function getAddr(key, configId){

        if(key === '') {
            XE.toast('danger', 'API 키를 등록해주세요');
            return false;
        } else if($('input[name='+ configId +'_keyword]').val() === '') {
            XE.toast('warning', '검색어를 입력해주세요');
            return false;
        }

        // AJAX 주소 검색 요청
        XE.ajax({
            url:"http://www.juso.go.kr/addrlink/addrLinkApiJsonp.do",	// 주소검색 OPEN API URL
            type:"post",
            data : {
                currentPage: $('input[name='+configId+'_currentPage]').val(),
                countPerPage: $('input[name='+configId+'_countPerPage]').val(),
                resultType: 'json',
                confmKey: key,
                keyword: $('input[name='+ configId +'_keyword]').val()
            },					// 요청 변수 설정
            dataType:"jsonp",											// 크로스도메인으로 인한 jsonp 이용, 검색결과형식 JSON
            crossDomain:true,
            success:function(jsonStr){									// jsonStr : 주소 검색 결과 JSON 데이터
                console.log(jsonStr);
                $("#list").html("");									// 결과 출력 영역 초기화
                var errCode = jsonStr.results.common.errorCode;
                if(errCode != "0"){
                    $("#pageApi").html("");
                    if(errCode ==  "E0001"){ alert("승인되지 않은 KEY입니다."); }
                    else if(errCode ==  "E0005"){ alert("검색어를 입력해주세요."); }
                    else if(errCode ==  "E0006"){ alert("시도명으로는 검색이 불가합니다."); }
                    else { alert("에러가 발생하였습니다. 잠시후 다시 시도해주세요."); }
                }else{
                    if(jsonStr!= null){
                        makeListJson(jsonStr, configId);							// 결과 JSON 데이터 파싱 및 출력
                        pageMake(jsonStr, key, configId);
                    }
                }
            }

            ,error: function(xhr,status, error){

                alert("에러발생");										// AJAX 호출 에러

            }

        });

    }

    // 주소검색한 리스트를 html에 생성
    function makeListJson(jsonStr, configId){
        var htmlStr = "";
        htmlStr += `<table class="table">`;

        htmlStr += `
        <tr>
            <th>주소</th>
            <th>동</th>
            <th>영문주소</th>
            <th>우편번호</th>
            <th></th>
        </tr>

        `;

        // jquery를 이용한 JSON 결과 데이터 파싱
        $(jsonStr.results.juso).each(function(){
            htmlStr += "<tr>";
            htmlStr += "<td>"+this.roadAddrPart1+"</td>";
            htmlStr += "<td>"+this.roadAddrPart2+"</td>";
            htmlStr += "<td>"+this.engAddr+"</td>";
            htmlStr += "<td>"+this.zipNo+"</td>";
            htmlStr += `<td>
                <input type="button" onclick="addressing('${this.zipNo}', '${this.jibunAddr}','${this.roadAddrPart1}', '${configId}')" value="선택"></td>
            </tr>`;

        });

        htmlStr += "</table>";
        // 결과 HTML을 FORM의 결과 출력 DIV에 삽입
        $("#list").html(htmlStr);
    }

    // 주소값 넣어주기
    function addressing(zipNo, jibunAddr,roadAddrPart1, configId){
        $('input[name=' + configId + '_postcode]').val(zipNo); // 우편주소
        $('input[name=' + configId + '_doro]').val(roadAddrPart1); // 도로명 주소
        $('input[name=' + configId + '_jibun]').val(jibunAddr); // 도로명 주소

        $('input[name=' + configId + '_currentPage]').val(1);
        $("#list").html("");
        $("#pageApi").html("");
        a2c_{{$config->get('id')}}(roadAddrPart1);
    }

    //페이지 이동
    function goPage(pageNum, key, configId){
        $('input[name='+configId+'_currentPage]').val(pageNum);
        getAddr(key, configId);
    }

    // json타입 페이지 처리 (주소정보 리스트 makeListJson(jsonStr); 다음에서 호출)
    function pageMake(jsonStr, key, configId){
        var total = jsonStr.results.common.totalCount; // 총건수
        var pageNum = $('input[name='+configId+'_currentPage]').val(); // 현재페이지
        var paggingStr = "";
        if(total < 1){
            var htmlStr = "";
            htmlStr += "<table>";
            htmlStr += "<tr>";
            htmlStr += "<td>검색결과가 없습니다.</td>";
            htmlStr += "</tr>";
            htmlStr += "</table>";
            $("#list").html(htmlStr);
            $("#pageApi").html("");
        }else{
            if(total > 1000){
                total=1000;
            }
            var PAGEBLOCK=5; // 10
            var pageSize=10; // 10
            var totalPages = Math.floor((total-1)/pageSize) + 1; // 총페이지
            var firstPage = Math.floor((pageNum-1)/PAGEBLOCK) * PAGEBLOCK + 1; // 리스트의 처음 ( (2-1)/10 ) * 10 + 1 // 1 11 21 31
            if( firstPage <= 0 ) firstPage = 1;	// 처음페이지가 1보다 작으면 무조건 1
            var lastPage = firstPage-1 + PAGEBLOCK; // 리스트의 마지막 10 20 30 40 50
            if( lastPage > totalPages ) lastPage = totalPages;	// 마지막페이지가 전체페이지보다 크면 전체페이지
            var nextPage = lastPage+1 ; // 11 21
            var prePage = firstPage-PAGEBLOCK ;


            paggingStr += `
            <nav aria-label="Page navigation example">
              <ul class="pagination">`;

            if( firstPage > PAGEBLOCK ){
                paggingStr +=  `<li class="page-item">
                                    <a class="page-link" href='javascript:goPage("${prePage}", "${key}", "${configId}");' aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>` ; // 처음 페이지가 아니면 <를 넣어줌
            }
            for(var i=firstPage; i<=lastPage; i++ ){
                if( pageNum == i )
                    paggingStr += `<li class="page-item active"><a class="page-link" href='javascript:goPage("${i}", "${key}", "${configId}");'>${i}</a></li>`;
                else
                    paggingStr += `<li class="page-item"><a class="page-link" href='javascript:goPage("${i}", "${key}", "${configId}");'>${i}</a></li>`;
            }
            if( lastPage < totalPages ){
                paggingStr +=  `<li class="page-item">
                                    <a class="page-link" href='javascript:goPage("${nextPage}", "${key}", "${configId}");' aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>`; // 마지막페이지가 아니면 >를 넣어줌
            }
            paggingStr += `</ul>
            </nav>`;
            $("#pageApi").html(paggingStr);
        }

    }

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
                    document.getElementById("doro_{{$config->get('id')}}").value = expRoadAddr;
                    // guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                    // guideTextBox.style.display = 'block';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById("jibun_{{$config->get('id')}}").value = expJibunAddr;
                    // guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                    // guideTextBox.style.display = 'block';
                } else {
                    guideTextBox.innerHTML = '';
                    guideTextBox.style.display = 'none';
                }

                a2c_{{$config->get('id')}}(roadAddr);
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
    function a2c_{{$config->get('id')}}(address){
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
</script>

