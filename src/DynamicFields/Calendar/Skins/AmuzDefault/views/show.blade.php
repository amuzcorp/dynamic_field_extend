@php
    if($data['start']) {
        $start_date_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['start']);
        $start = $start_date_time->toDateString();
        if((int)date('Y', strtotime($start)) < 0) {
            $start = '-';
        } else {
            $start = date('Y년 m월 d일', strtotime($start));
            $start_time = date('H시 i분', strtotime(date('Y-m-d '). $start_date_time->toTimeString()));
            if($start_time === '00시 00분') $start_time = '';
            $start = $start.' '.$start_time;
        }
    }
    if($data['end']) {
        $end_date_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['end']);
        $end = $end_date_time->toDateString();
        if((int)date('Y', strtotime($end)) < 0) {
            $end = '-';
        } else {
            $end = date('Y년 m월 d일', strtotime($end));
            $end_time = date('H시 i분', strtotime(date('Y-m-d '). $end_date_time->toTimeString()));
            if($end_time === '23시 59분') $end_time = '';
            $end = $end.' '.$end_time;
        }
    }
@endphp

<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_text __xe_df_text_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>

    @if($config->get('date_type') == 'single')
        @if($config->get('time_type') == 'single')
            <div>
                <span>{{ $start }}</span>
            </div>
        @else
            <div>
                <span>{{ $start }}</span><span> ~ </span><span>{{ $end }}</span>
            </div>
        @endif
    @else
        <div>
            <span>{{ $start }}</span><span> ~ </span><span>{{ $end }}</span>
        </div>
    @endif
</div>
