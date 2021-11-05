<style>
    .text-white {
        color:#ffffff !important;
    }
</style>
@php
if($data['columns'] !== '') {
    $columns = json_dec($data['columns']);
} else {
    $columns = [];
}
@endphp
<div>
    <label>{{ xe_trans($config->get('label')) }}</label>
    <label class="text-primary" style="float:right;" onclick="add_TO_DO_List('{{$config->get('id')}}')">일정 추가</label>
    <input type="hidden" name="{{$config->get('id')}}_count" value="{{count($columns)}}" />
    <input type="hidden" name="{{$config->get('id')}}_columns" value="{{$data['columns']}}" />
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
                        @foreach($columns as $column)
                            <tr>
                                <td><input class="form-control" type="text" name="{{$config->get('id')}}_title[]" value="{{$column->title}}" onchange="setToDOListColumn('{{$config->get('id')}}')" /></td>
                                <td><input type="checkbox"
                                           class="TO_DO_list_checked"
                                           name="{{$config->get('id')}}_check[]"
                                           @if($column->checked)
                                           checked=""
                                           @endif
                                           onchange="setToDOListColumn('{{$config->get('id')}}')"/></td>
                                <td><a class="btn btn-danger btn-sm config_list_remove text-white">제거</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
    </div>
</div>


@include('dynamic_field_extend::src.DynamicFields.ToDoList.Skins.Common.views.script')
