<fieldset class="dynamic_field_rate half">
    <input type="radio" readonly="readonly" @if($data['num'] === 10) checked @endif name="{{$key['num']}}" value="10" /><label title="5 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 8) checked @endif name="{{$key['num']}}" value="8" /><label title="4 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 6) checked @endif name="{{$key['num']}}" value="6" /><label title="3 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 4) checked @endif name="{{$key['num']}}" value="4" /><label title="2 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 2) checked @endif name="{{$key['num']}}" value="2" /><label title="1 star"></label>
</fieldset>
