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
                <label>{{ str_replace("_data","",$key) }}</label>
                <div style="width: 100%">
                    <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                            onchange="display_chk(this, '{{ $config->get('id') }}_{{str_replace('_data','',$key)}}_morning')"
                            class="xe-form-control" style="width: 80px;float: left">
                        <option value="closed" @if($my_val[0] == 'closed') selected @endif >오전휴무</option>
                        @for($i=0; $i<13; $i++)
                            {{--@if($my_val[0] == "closed")--}}
                            {{--<option value="closed" @if($my_val[0] == "closed") selected @endif >오전휴무</option>--}}
                            {{--@else--}}
                            <option value="{{$i}}"
                                    @if($my_val[0] == (String)$i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif </option>
                            {{--@endif--}}
                        @endfor
                    </select>
                    <div class="{{ $config->get('id') }}_{{str_replace("_data","",$key)}}_morning"
                         @if($my_val[0] == 'closed') style="display: none" @endif>
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                                class="xe-form-control" style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}"
                                        @if($my_val[1] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">~ </label>
                        <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                                class="xe-form-control" style="width: 80px;float: left">
                            @for($i=0; $i<13; $i++)
                                <option value="{{$i}}"
                                        @if($my_val[2] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                                class="xe-form-control" style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}"
                                        @if($my_val[3] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                    </div>
                    <label style="float: left;width:25px;">, </label>

                    <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                            onchange="display_chk(this, '{{ $config->get('id') }}_{{str_replace('_data','',$key)}}_afternoon')"
                            class="xe-form-control" style="width: 80px;float: left">
                        <option value="closed" @if($my_val[4] == "closed") selected @endif >오후휴무</option>
                        @for($i=12; $i<25; $i++)

                            {{--@if($my_val[4] == "closed")--}}
                            {{--<option value="closed" @if($my_val[4] == "closed") selected @endif >오후휴무</option>--}}
                            {{--@else--}}
                            <option value="{{$i}}"
                                    @if($my_val[4] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            {{--@endif--}}
                        @endfor
                    </select>

                    <div class="{{ $config->get('id') }}_{{str_replace("_data","",$key)}}_afternoon"
                         @if($my_val[4] == 'closed') style="display: none" @endif>
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                                class="xe-form-control" style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}"
                                        @if($my_val[5] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">~ </label>
                        <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                                class="xe-form-control" style="width: 80px;float: left">
                            @for($i=12; $i<25; $i++)
                                <option value="{{$i}}"
                                        @if($my_val[6] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_{{str_replace("_data","",$key)}}_data[]"
                                class="xe-form-control" style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}"
                                        @if($my_val[7] == $i) selected @endif > @if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div style="clear: both"></div>
            @endif
        @endforeach
        <br>
        <label>기타</label>
        <div id="{{$config->get('id')}}_etc_list">

        </div>
        <div id="{{$config->get('id')}}_etc_input">
            <div id="{{$config->get('id')}}_etc_content">
                <div style="width: 100%">
                    <input type="text" class="{{$config->get('id')}}_Datepicker xe-form-control"
                           style="width: 120px;float: left" placeholder="날짜 선택">
                    <label style="float: left;width:25px;">, </label>
                    <label style="float: left;"><input type="text" class="xe-form-control"
                                                       name="{{$config->get('id')}}_etc_title"
                                                       value=""
                                                       style="width: 200px;float: left"
                                                       placeholder="일정 제목을 입력해주세요."></label>
                    <label style="float: left;width:25px;"></label>
                    <div style="clear: both;margin-bottom: 5px"></div>
                    <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                            onchange="display_chk(this, '{{ $config->get('id') }}_etc_morning')"
                            style="width: 80px;float: left">
                        <option value="closed">오전휴무</option>
                        @for($i=0; $i<13; $i++)
                            <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                        @endfor
                    </select>
                    <div class="{{ $config->get('id') }}_etc_morning" style="display: none">
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                                style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">~ </label>
                        <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                                style="width: 80px;float: left">
                            @for($i=0; $i<13; $i++)
                                <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                                style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                    </div>
                    <label style="float: left;width:25px;">, </label>

                    <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                            onchange="display_chk(this, '{{ $config->get('id') }}_etc_afternoon')"
                            style="width: 80px;float: left">
                        <option value="closed">오후휴무</option>
                        @for($i=12; $i<25; $i++)
                            <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                        @endfor
                    </select>
                    <div class="{{ $config->get('id') }}_etc_afternoon" style="display: none">
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                                style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">~ </label>
                        <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                                style="width: 80px;float: left">
                            @for($i=12; $i<25; $i++)
                                <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                        <label style="float: left;">:</label>
                        <select name="{{$config->get('id')}}_etc_data[]" class="xe-form-control"
                                style="width: 80px;float: left">
                            @for($i=0; $i<60; $i++)
                                <option value="{{$i}}">@if($i<10){{"0".$i}}@else{{$i}}@endif</option>
                            @endfor
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
            <button type="button" class="xe-btn" onclick="add_schedule()" style="margin-top: 10px">일정 추가</button>
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


    function add_schedule() {
        var add_data = [];
        var new_div = document.createElement("div");
        var sel_date = document.querySelector(".{{$config->get('id')}}_Datepicker").value;
        var sel_title = document.querySelector('input[name="{{$config->get('id')}}_etc_title"]').value;

        if (sel_date == "") {
            alert("날짜를 선택해주세요.");
            return;
        }

        for (var i = 0; i < etc_sel_data.length; i++) {
            if (typeof etc_sel_data[i] !== 'undefined' && etc_sel_data[i].length > 0) {
                if (etc_sel_data[i][0] == sel_date) {
                    alert("이미 등록된 날짜입니다.");
                    return;
                }
                //console.log(etc_sel_data[i][0]);
            }
        }


        var sel_etc = document.querySelectorAll('select[name="{{$config->get('id')}}_etc_data[]"]');
        new_div.innerHTML = "<div class='{{$config->get('id')}}_" + sel_date + "'>";
        new_div.innerHTML += sel_date + ", ";
        new_div.innerHTML += sel_title + ", ";
        if (sel_etc[0].value == "closed") {
            new_div.innerHTML += "오전 휴무, ";
        } else {
            new_div.innerHTML += "오전 " + sel_etc[0].value + "시 " + sel_etc[1].value + "분 ~";
            new_div.innerHTML += " " + sel_etc[2].value + "시 " + sel_etc[3].value + "분";
        }

        if (sel_etc[4].value == "closed") {
            new_div.innerHTML += "오후 휴무";
        } else {
            new_div.innerHTML += ", 오후 " + sel_etc[4].value + "시 " + sel_etc[5].value + "분 ~";
            new_div.innerHTML += " " + sel_etc[6].value + "시 " + sel_etc[7].value + "분";
        }

        new_div.innerHTML += "<a href='javascript:{{$config->get('id')}}_del_schedule(\"{{$config->get('id')}}_" + sel_date + "\")'>[선택삭제]</a>";
        new_div.innerHTML += "</div>";
        document.getElementById("{{$config->get('id')}}_etc_list").appendChild(new_div);

        add_data.push(sel_date);
        add_data.push(sel_title);
        for (var j = 0; j < sel_etc.length; j++) {
            add_data.push(sel_etc[j].value);
        }

        etc_sel_data.push(add_data);
        document.getElementById("{{$config->get('id')}}_etc_schedule_data").value = JSON.stringify(etc_sel_data);
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

        new_div.innerHTML += "<a href='javascript:{{$config->get('id')}}_del_schedule(\"{{$config->get('id')}}_" + sel_date + "\")'>[선택삭제]</a>";
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

    function {{$config->get('id')}}_del_schedule(my_date) {
        //alert("delete!");
        //
        var del_date = my_date.replace("{{$config->get('id')}}_", "");
        for (var i = 0; i < etc_sel_data.length; i++) {
            if (typeof etc_sel_data[i] !== 'undefined' && etc_sel_data[i].length > 0) {
                if (etc_sel_data[i][0] == del_date) {
                    delete etc_sel_data[i];
                }
                //console.log(etc_sel_data[i][0]);
            }
        }
        var my_tag = document.querySelector("." + my_date).parentNode;
        my_tag.remove();

        document.getElementById("{{$config->get('id')}}_etc_schedule_data").value = JSON.stringify(etc_sel_data);
        console.log(document.getElementById("{{$config->get('id')}}_etc_schedule_data").value);
    }

    $(function () {
        $(".{{$config->get('id')}}_Datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    function display_chk(my_sel, my_class) {
        if (my_sel.value == "closed") {
            document.querySelector("." + my_class).style.display = "none";
        } else {
            document.querySelector("." + my_class).style.display = "block";
        }
    }
</script>
{{--<div class="xe-form-group xe-dynamicField">--}}
{{--<label class="xu-form-group__label __xe_df __xe_df_category __xe_df_category_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>--}}
{{--@if ($config->get('skinDescription') !== '')<small>{{$config->get('skinDescription')}}</small>@endif--}}
{{--<select name="{{$config->get('id') . '_item_id'}}" class="xe-form-control" data-valid-name="{{ xe_trans($config->get('label')) }}">--}}
{{--<option value="">{{xe_trans($config->get('label'))}}</option>--}}
{{--@foreach ($items as $item)--}}
{{--<option value="{{$item->id}}">{{$item->word}}</option>--}}
{{--@endforeach--}}
{{--</select>--}}
{{--</div>--}}
