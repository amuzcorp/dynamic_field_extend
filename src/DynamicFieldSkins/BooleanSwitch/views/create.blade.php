<style>
    .wrapper { position: relative; }
    #{{$config->get('id')}}_switch {
        position: absolute;
        /* hidden */
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    .switch_label {
        position: relative;
        cursor: pointer;
        display: inline-block;
        width: 58px;
        height: 33px;
        background: #fff;
        border: 2px solid rgba(156, 156, 156, 0.33);
        border-radius: 20px;
        transition: 0.2s;
    }
    .switch_label:hover {
        background: #efefef;
    }
    .onf_btn {
        position: absolute;
        top: 5px;
        left: 5px;
        display: inline-block;
        width: 19px;
        height: 19px;
        border-radius: 20px;
        background: rgba(109, 109, 109, 0.33);
        transition: 0.2s;
    }
    /* checking style */
    #{{$config->get('id')}}_switch:checked+.switch_label {
        background: #0012b7;
        border: 2px solid #0012b7;
    }

    #{{$config->get('id')}}_switch:checked+.switch_label:hover {
        background: #0013e1;
    }

    /* move */
    #{{$config->get('id')}}_switch:checked+.switch_label .onf_btn {
        left: 33px;
        background: #fff;
        box-shadow: 1px 2px 3px #00000020;
    }
</style>
<div class="xe-form-group xe-dynamicField">
    <div class="xe-form-inline __xe-input-group">
        <label class="xe-label">
            <strong>{{ xe_trans($config->get('label')) }}</strong>
        </label>
        <input type="hidden" name="{{$key['boolean']}}" value="{{$data['boolean']?:0}}" />
        <div class="wrapper">
            <input type="checkbox" id="{{$config->get('id')}}_switch" @if($data['boolean'] === 1) checked="" @endif>
            <label for="{{$config->get('id')}}_switch" class="switch_label">
                <span class="onf_btn"></span>
            </label>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#{{$config->get('id')}}_switch").change(function(){
            if($("#{{$config->get('id')}}_switch").is(":checked")){
                $('input[name={{$key['boolean']}}]').val(1);
            }else{
                $('input[name={{$key['boolean']}}]').val(0);
            }
        });

    });
</script>
