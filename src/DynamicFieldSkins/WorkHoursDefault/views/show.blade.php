{{--{{XeFrontend::js('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js')->appendTo('head')->load() }}--}}
{{XeFrontend::js('https://code.jquery.com/ui/1.12.1/jquery-ui.js')->appendTo('head')->load() }}
{{XeFrontend::css('http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css')->load()}}


<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $config->get('id') }}">{{ xe_trans($config->get('label')) }}</label>
    <input type="hidden" id="{{$config->get('id')}}_etc_schedule_data" name="{{$config->get('id')}}_etc_schedule_data"
           value="{{$data["etc_schedule_data"]}}">
    @if ($config->get('skinDescription') !== '')
        <small>{{ $config->get('skinDescription') }}</small>
    @endif


    <br><label>{{$now_str}}</label>
    <br><label>{{$today_str}}</label><br><br>

@php
    $week_array=["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
    $etc_array=json_decode($data["etc_schedule_data"]);
@endphp


<div class="xu-form-group__box">
    @foreach($data as $key=>$value)
        @if($key!="etc_schedule_data")
            @php
                $my_val = json_decode($value);
                if(!$my_val){
                    $my_val = ["close",0,0,0,"closed",0,0,0];
                }
            @endphp
            <label>{{str_replace("_data","",$key)}}</label>
            <div style="width: 100%">
                <label>@if($my_val[0] == 'closed') 오전 휴무 @else 오전 {{$my_val[0]}}시 {{$my_val[1]}}분 ~ {{$my_val[2]}}
                    시 {{$my_val[3]}}분@endif</label>
                <label>, </label>
                <label>@if($my_val[4] == "closed") 오후 휴무 @else 오후 {{$my_val[4]}}시 {{$my_val[5]}}분 ~ {{$my_val[6]}}
                    시 {{$my_val[7]}}분@endif</label>
            </div>
            <div style="clear: both"></div>
        @endif
    @endforeach

        <br>
        <div>
            <label>기타</label>
            <div id="{{$config->get('id')}}_etc_list"></div>
        </div>
</div>


</div>

<script>
    var etc_sel_data = [];
    var get_etc_data_str = document.getElementById("{{$config->get('id')}}_etc_schedule_data").value;
    var get_etc_data_array = [];

    if (get_etc_data_str) {
        get_etc_data_array = JSON.parse(get_etc_data_str);
    }

    for (var i = 0; i < get_etc_data_array.length; i++) {
        if (get_etc_data_array[i] != null) {
            add_schedule_from_data(get_etc_data_array[i][0], get_etc_data_array[i][1], get_etc_data_array[i]);
        }
    }

    function add_schedule_from_data(my_date, my_title, data_array) {
        var add_data = [];
        var new_div = document.createElement("div");
                {{--var sel_date = document.querySelector(".{{$config->get('id')}}_Datepicker").value;--}}
                {{--var sel_title = document.querySelector('input[name="{{$config->get('id')}}_etc_title"]').value;--}}
        var sel_date = my_date;
        var sel_title = my_title;

        if (sel_date == "") {
            alert("날짜를 선택해주세요.");
            return;
        }

        for (var i = 0; i < data_array.length; i++) {
            if (typeof data_array[i] !== 'undefined' && data_array[i].length > 0) {
                if (data_array[i][0] == sel_date) {
                    //alert("이미 등록된 날짜입니다.");
                    //return;
                }
                //console.log(etc_sel_data[i][0]);
            }
        }

        var sel_etc = data_array;
        new_div.innerHTML = "<div class='{{$config->get('id')}}_" + sel_date + "'>";
        new_div.innerHTML += sel_date + ", ";
        new_div.innerHTML += sel_title + ", ";
        if (sel_etc[2] == "closed") {
            new_div.innerHTML += "오전 휴무 ";
        } else {
            new_div.innerHTML += "오전 " + sel_etc[2] + "시 " + sel_etc[3] + "분 ~";
            new_div.innerHTML += " " + sel_etc[4] + "시 " + sel_etc[5] + "분";
        }

        if (sel_etc[6] == "closed") {
            new_div.innerHTML += "오후 휴무";
        } else {
            new_div.innerHTML += ", 오후 " + sel_etc[6] + "시 " + sel_etc[7] + "분 ~";
            new_div.innerHTML += " " + sel_etc[8] + "시 " + sel_etc[9] + "분";
        }

        {{--new_div.innerHTML += "<a href='javascript:{{$config->get('id')}}_del_schedule(\"{{$config->get('id')}}_" + sel_date + "\")'>[선택삭제]</a>";--}}
            new_div.innerHTML += "</div>";
        document.getElementById("{{$config->get('id')}}_etc_list").appendChild(new_div);

        add_data.push(sel_date);
        add_data.push(sel_title);
        for (var j = 2; j < sel_etc.length; j++) {
            add_data.push(sel_etc[j]);
        }

        etc_sel_data.push(add_data);
        //console.log(add_data);
        //console.log(etc_sel_data);
        document.getElementById("{{$config->get('id')}}_etc_schedule_data").value = JSON.stringify(etc_sel_data);
    }
</script>


