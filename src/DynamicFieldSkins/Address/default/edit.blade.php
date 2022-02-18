<div class="xe-form-group xe-dynamicField">
    <input type="hidden" name="{{$config->get('id')}}_currentPage" value="1"/>				<!-- 요청 변수 설정 (현재 페이지. currentPage : n > 0) -->
    <input type="hidden" name="{{$config->get('id')}}_countPerPage" value="6"/>		<!-- 요청 변수 설정 (페이지당 출력 개수. countPerPage 범위 : 0 < n <= 100) -->

    <label class="xu-form-group__label __xe_df __xe_df_address __xe_df_address_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>
    @if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif
    <div class="xe-form-inline">
        <input type="text" name="{{$key['postcode']}}" class="xe-form-control xu-form-group__control" readonly="readonly" placeholder="{{xe_trans('xe::postCode')}}" value="{{$data['postcode']}}" />
        <input type="text" name="{{$config->get('id')}}_keyword" class="xe-form-control xu-form-group__control" placeholder="검색어를 입력해주세요" value=""/>
        <input type="button" class="xe-btn xe-btn-default" onclick="{{$config->get('id')}}getAddr( '{{$address_key}}')" value="{{xe_trans('xe::findPostCode')}}" />
    </div>
    <div class="xe-form-inline">
        <input type="text" name="{{$key['address1']}}" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::address')}}" readonly="readonly" value="{{$data['address1']}}">
        <input type="text" name="{{$key['address2']}}" class="xe-form-control xu-form-group__control" placeholder="{{xe_trans('xe::detailedAddress')}}" value="{{$data['address2']}}" data-valid-name="{{ xe_trans('xe::detailedAddress') }}">
    </div>
</div>

<div id="{{$config->get('id')}}list"> <!-- 검색 결과 리스트 출력 영역 --> </div>
<div class="paginate" id="{{$config->get('id')}}pageApi"></div>

<script type="text/javascript">
    // 주소 검색후 데이터 받아오기
    function {{$config->get('id')}}getAddr(key){
        if(key === '') {
            XE.toast('danger', 'API 키를 등록해주세요');
            return false;
        } else if($('input[name={{$config->get('id')}}_keyword]').val() === '') {
            XE.toast('warning', '검색어를 입력해주세요');
            return false;
        }

        // AJAX 주소 검색 요청
        XE.ajax({
            url:"//www.juso.go.kr/addrlink/addrLinkApiJsonp.do",	// 주소검색 OPEN API URL
            type:"post",
            data : {
                currentPage: $('input[name={{$config->get('id')}}_currentPage]').val(),
                countPerPage: $('input[name={{$config->get('id')}}_countPerPage]').val(),
                resultType: 'json',
                confmKey: key,
                keyword: $('input[name={{$config->get('id')}}_keyword]').val()
            },					// 요청 변수 설정
            dataType:"jsonp",											// 크로스도메인으로 인한 jsonp 이용, 검색결과형식 JSON
            crossDomain:true,
            success:function(jsonStr){									// jsonStr : 주소 검색 결과 JSON 데이터
                $("#{{$config->get('id')}}list").html("");									// 결과 출력 영역 초기화
                var errCode = jsonStr.results.common.errorCode;
                if(errCode != "0"){
                    $("#{{$config->get('id')}}pageApi").html("");
                    if(errCode ==  "E0001"){ XE.toast('danger',"승인되지 않은 KEY 입니다."); }
                    else if(errCode ==  "E0005"){ XE.toast('danger', "검색어를 입력해주세요."); }
                    else if(errCode ==  "E0006"){ XE.toast('danger', "시도명으로는 검색이 불가합니다."); }
                    else { XE.toast('danger', "에러가 발생하였습니다. 잠시후 다시 시도해주세요."); }
                }else{
                    if(jsonStr!= null){
                        makeListJson(jsonStr);							// 결과 JSON 데이터 파싱 및 출력
                        pageMake(jsonStr, key);
                    }
                }
            }

            ,error: function(xhr,status, error){

                alert("에러발생");										// AJAX 호출 에러

            }

        });

    }



    // 주소검색한 리스트를 html에 생성

    function {{$config->get('id')}}makeListJson(jsonStr){
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
                <input type="button" onclick="{{$config->get('id')}}addressing('${this.zipNo}','${this.roadAddrPart1}','${this.roadAddrPart2}')" value="선택"></td>
            </tr>`;

        });

        htmlStr += "</table>";
        // 결과 HTML을 FORM의 결과 출력 DIV에 삽입
        $("#{{$config->get('id')}}list").html(htmlStr);
    }



    // 주소값 넣어주기

    function {{$config->get('id')}}addressing(zipNo,roadAddrPart1,roadAddrPart2){
        $('input[name={{$config->get('id')}}_postcode]').val(zipNo); // 우편주소
        $('input[name={{$config->get('id')}}_address1]').val(roadAddrPart1 + ' ' + roadAddrPart2 ); // 도로명 주소
        $('input[name={{$config->get('id')}}_currentPage]').val(1);
        $("#{{$config->get('id')}}list").html("");
        $("#{{$config->get('id')}}pageApi").html("");
    }



    //페이지 이동

    function {{$config->get('id')}}goPage(pageNum, key){
        $('input[name={{$config->get('id')}}_currentPage]').val(pageNum);
        {{$config->get('id')}}getAddr(key);
    }



    // json타입 페이지 처리 (주소정보 리스트 makeListJson(jsonStr); 다음에서 호출)

    function {{$config->get('id')}}pageMake(jsonStr, key){
        var total = jsonStr.results.common.totalCount; // 총건수
        var pageNum = $('input[name={{$config->get('id')}}_currentPage]').val(); // 현재페이지
        var paggingStr = "";
        if(total < 1){
            var htmlStr = "";
            htmlStr += "<table>";
            htmlStr += "<tr>";
            htmlStr += "<td>검색결과가 없습니다.</td>";
            htmlStr += "</tr>";
            htmlStr += "</table>";
            $("#{{$config->get('id')}}list").html(htmlStr);
            $("#{{$config->get('id')}}pageApi").html("");
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
                                    <a class="page-link" href='javascript:{{$config->get('id')}}goPage("${prePage}", "${key}");' aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>` ; // 처음 페이지가 아니면 <를 넣어줌
            }
            for(var i=firstPage; i<=lastPage; i++ ){
                if( pageNum == i )
                    paggingStr += `<li class="page-item active"><a class="page-link" href='javascript:{{$config->get('id')}}goPage("${i}", "${key}");'>${i}</a></li>`;
                else
                    paggingStr += `<li class="page-item"><a class="page-link" href='javascript:{{$config->get('id')}}goPage("${i}", "${key}");'>${i}</a></li>`;
            }
            if( lastPage < totalPages ){
                paggingStr +=  `<li class="page-item">
                                    <a class="page-link" href='javascript:{{$config->get('id')}}goPage("${nextPage}", "${key}");' aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>`; // 마지막페이지가 아니면 >를 넣어줌
            }
            paggingStr += `</ul>
            </nav>`;
            $("#{{$config->get('id')}}pageApi").html(paggingStr);
        }

    }
</script>
