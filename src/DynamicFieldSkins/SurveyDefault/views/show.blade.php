<table class="w-100">
    <colgroup>
        <col width="15%">
        <col width="">
        <col width="15%">
        <col width="15%">
    </colgroup>
    <tr>
        <th>
            <span class="m-hide">번호</span>
            <span class="m-show">No</span>
        </th>
        <th>내용</th>
        <th>
            <span class="m-hide">그렇다.</span>
            <span class="m-show">O</span>
        </th>
        <th>
            <span class="m-hide">그렇지 않다.</span>
            <span class="m-show">X</span>
        </th>
    </tr>
    @if(!empty($content))
        @foreach($content as $key => $item)
            <tr>
                <td>{{$key + 1}} 번</td>
                <td>{{$item->text}}</td>
                <td><input class="form-check-input position-static" type="checkbox" value="option1" @if($item->checkbox1 !== false) checked="" @endif></td>
                <td><input class="form-check-input position-static" type="checkbox" value="option1" @if($item->checkbox2 !== false) checked="" @endif></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">
                등록된 설문이 없습니다
            </td>
        </tr>
    @endif
</table>
