<table class="table text-center question_form">
    <thead>
    <tr>
        <th colspan="2" class="text-center">설문조서</th>
    </tr>
    </thead>
</table>
<div>
    <input type="hidden" name="{{$question_field}}_total_question" value="{{count($question)}}">
    @foreach($question as $key => $val)
        <table class="table text-center question_form">
            <thead>
            <tr>
                <td colspan="2">
                    <input type="text"
                           class="form-control"
                           value="{{$val->title}}"
                           readonly>
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach($val->questions as $question_key => $question_val)
                <tr>
                    <td style="width:5%;">
                        <input type="radio"
                               name="{{$question_field}}_question_{{$key+1}}_radio"
                               @if($question_key === 0)
                                checked=""
                               @endif
                               value="{{ $question_key + 1 }}" onchange="setQuestions( {{count($val->questions)}}, {{$key+1}}, {{$question_key + 1}} )">
                    </td>
                    <td>
                        <input type="text" class="form-control mb-5px" value="{{$question_val->value}}" readonly>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
</div>


