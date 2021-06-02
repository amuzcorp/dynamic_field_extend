<div class="xe-form-group xe-dynamicField">
    <label class="xu-form-group__label __xe_df __xe_df_text __xe_df_text_{{ $config->get('id') }}">{{ xe_trans($config->get('label')) }}</label>
    <input type="hidden" id="{{$config->get('id')}}_etc_schedule_data" name="{{$config->get('id')}}_etc_schedule_data"
           value="">
    @if ($config->get('skinDescription') !== '')
        <small>{{ $config->get('skinDescription') }}</small>
    @endif


    <div class="xu-form-group__box">
        <table class="xe-table table table-striped text-center center">
            <thead>
                <tr>
                    <th class="text-center">요일</th>
                    <td class="text-center">구분</td>
                    <td class="text-center">시작시간</td>
                    <td class="text-center"></td>
                </tr>
            </thead>
        @foreach(\Amuz\XePlugin\DynamicFieldExtend\Resources::weeks as $week)
            @foreach(['morning','afternoon'] as $time)
            <tr>
                @if($time == 'morning')
                <th rowspan="2" class="text-center">{{ \Amuz\XePlugin\DynamicFieldExtend\Resources::weeks_name_full[$week] }}</th>
                @endif
                <td class="text-center">{{\Amuz\XePlugin\DynamicFieldExtend\Resources::time_name[$time]}}</td>

                    @include('dynamic_field_extend::src.DynamicFieldSkins.WorkHoursDefault.views.time-selector')

                @if($time == 'morning')
                <td rowspan="2" class="text-center">
                    @if($week != "mon") <a href="#"><i class="xi-documents"></i> 복제</a> @endif
                </td>
                @endif
            </tr>
            @endforeach
        @endforeach
            <tr>
                <th>예외일정</th>
                <td colspan="3">
                    <div class="form-inline xe-form-inline">
                    <input type="date" class="form-control xe-form-control"/>
                    <input type="text" class="form-control xe-form-control" placeholder="일정 제목" />
                    <button class="xe-btn xe-btn-primary-outline btn btn-default"><i class="xi-plus"></i> 새 예외일정 등록</button>
                    </div>
                </td>
            </tr>
        </table>
</div>


<script>
    var etc_sel_data = [];

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
        {{--console.log(document.getElementById("{{$config->get('id')}}_etc_schedule_data").value);--}}
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
