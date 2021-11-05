@php
    if($data['columns'] !== '') {
        $columns = json_dec($data['columns']);
    } else {
        $columns = [];
    }
@endphp
<h4>{{ xe_trans($config->get('label')) }}</h4>
<div>
    <table class="table">
        <colgroup>
            <col style=""/>
            <col style="width:10%"/>
        </colgroup>
        <thead>
        <tr>
            <th>{{xe_trans($config->get('label'))}} 리스트</th>
            <th>체크</th>
        </tr>
        </thead>
        <tbody id="{{$config->get('id')}}_TO_DO_List">
        @foreach($columns as $column)
            <tr>
                <td><label>{{$column->title}}</label></td>
                <td><input type="checkbox"
                           class="TO_DO_list_checked"
                           @if($column->checked) checked="" @endif/></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
