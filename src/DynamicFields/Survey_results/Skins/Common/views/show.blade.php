{{--@if($question !== '')--}}
{{--    <table class="table text-center question_form">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th colspan="2" class="text-center">설문조서</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--    </table>--}}
{{--    <div>--}}
{{--        @foreach(json_dec($question) as $key => $val)--}}
{{--            <table class="table text-center question_form">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <td colspan="2">--}}
{{--                        <input type="text"--}}
{{--                               class="form-control"--}}
{{--                               value="{{$val->title}}"--}}
{{--                               readonly>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($val->questions as $question_key => $question_val)--}}
{{--                    <tr>--}}
{{--                        <td style="width:5%;">--}}
{{--                            <input type="radio"--}}
{{--                                   name="{{$config->get('id')}}_columns_question_{{$key+1}}_radio"--}}
{{--                                   readonly--}}
{{--                                   @if(json_dec($data['result'])[$key] === ($question_key + 1))--}}
{{--                                   checked=""--}}
{{--                                   @endif>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <input type="text" class="form-control mb-5px" value="{{$question_val->value}}" readonly>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--@endif--}}
