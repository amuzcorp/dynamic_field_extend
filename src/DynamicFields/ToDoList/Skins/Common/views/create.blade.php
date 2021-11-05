<style>
    .text-white {
        color:#ffffff !important;
    }
</style>

<div>
    <label>{{ xe_trans($config->get('label')) }}</label>
    <label class="text-primary" style="float:right;" onclick="add_TO_DO_List('{{$config->get('id')}}')">일정 추가</label>
    <input type="hidden" name="{{$config->get('id')}}_count" value="0" />
    <input type="hidden" name="{{$config->get('id')}}_columns" value="" />
    <div class="panel">
        <div class="panel-body">
            <div class="card">
                <div class="card-body">

                    <table class="table">
                        <colgroup>
                            <col style=""/>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>{{xe_trans($config->get('label'))}} 리스트</th>
                            <th>체크</th>
                            <th>작업</th>
                        </tr>
                        </thead>
                        <tbody id="{{$config->get('id')}}_TO_DO_List">
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>


@include('dynamic_field_extend::src.DynamicFields.ToDoList.Skins.Common.views.script')
