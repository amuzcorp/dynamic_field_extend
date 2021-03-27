<fieldset class="dynamic_field_rate">
    <input type="radio" readonly="readonly" @if($data['num'] === 10) checked @endif value="10" /><label title="5 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 9) checked @endif  value="9" /><label class="half" title="4 1/2 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 8) checked @endif value="8" /><label title="4 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 7) checked @endif value="7" /><label class="half" title="3 1/2 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 6) checked @endif value="6" /><label title="3 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 5) checked @endif value="5" /><label class="half" title="2 1/2 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 4) checked @endif value="4" /><label title="2 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 3) checked @endif value="3" /><label class="half" title="1 1/2 stars"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 2) checked @endif value="2" /><label title="1 star"></label>
    <input type="radio" readonly="readonly" @if($data['num'] === 1) checked @endif value="1" /><label class="half" title="1/2 star"></label>
</fieldset>
