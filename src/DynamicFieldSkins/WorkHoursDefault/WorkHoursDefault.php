<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFieldSkins\WorkHoursDefault;

use Xpressengine\DynamicField\AbstractSkin;

class WorkHoursDefault extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Work hours default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src.DynamicFieldSkins.WorkHoursDefault.views';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
    }

    /**
     * 조회할 때 사용 될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function show(array $args)
    {
        list($data, $key) = $this->filter($args);

        $chk_data = array_merge($data, $this->mergeData);

        $result_str = "";
        $now_chk_str = "";
//        var_dump($chk_data["etc_schedule_data"]);
//
//        var_dump(strtotime("09:00"));
//        var_dump(strtotime(date("H:i",time())));
        $etc_day_chk = true;
        if(isset($chk_data["etc_schedule_data"])) {
            if(json_decode($chk_data["etc_schedule_data"])) {
                foreach (json_decode($chk_data["etc_schedule_data"]) as $value) {
                    if ($value) {
                        if ($value[0] == date("Y-m-d", time())) {
                            $etc_day_chk = false;
                            $result_str = "오늘은 " . $value[1] . "입니다. 업무시간은 ";
                            if ($value[2] == "closed" && $value[6] == "closed") {
                                $result_str .= "오늘은 오전, 오후 휴무 입니다.";
                                $now_chk_str = "현재 업무시간이 아닙니다.";
                            } else {
                                if ($value[2] == "closed") {
                                    $result_str .= "오전 휴무, ";
                                } else {
                                    $result_str .= "오전 " . $value[2] . ":" . $this->plus_zero($value[3]) . "~" . $value[4] . ":" . $this->plus_zero($value[5]);
                                }

                                if ($value[6] == "closed") {
                                    $result_str .= "오후 휴무 입니다. ";
                                } else {
                                    $result_str .= "오후 " . $this->after_none_value($value[6]) . ":" . $this->plus_zero($value[7]) . "~" . $this->after_none_value($value[8]) . ":" . $this->plus_zero($value[9]) . "까지 입니다.";
                                }

                                $now_time = strtotime(date("H:i", time()));
                                $morning_start = strtotime($this->plus_zero($value[2]) . ":" . $this->plus_zero($value[3]));
                                $morning_end = strtotime($this->plus_zero($value[4]) . ":" . $this->plus_zero($value[5]));
                                $after_start = strtotime($this->plus_zero($value[6]) . ":" . $this->plus_zero($value[7]));
                                $after_end = strtotime($this->plus_zero($value[8]) . ":" . $this->plus_zero($value[9]));
                                if ($morning_start < $now_time && $now_time < $morning_end) {
                                    $now_chk_str = "현재 업무시간입니다.";
                                } else if ($after_start < $now_time && $now_time < $after_end) {
                                    $now_chk_str = "현재 업무시간입니다.";
                                } else {
                                    $now_chk_str = "현재 업무시간이 아닙니다.";
                                }
                            }
                        }
                    }
                }
            }
        }


        if($etc_day_chk){
            $value = json_decode($chk_data[date("D", time())."_data"]);
            if($value) {
                $result_str = "";
                if ($value[0] == "closed" && $value[4] == "closed") {
                    $result_str .= "오늘은 오전, 오후 휴무 입니다.";
                    $now_chk_str = "현재 업무시간이 아닙니다.";
                } else {
                    if ($value[0] == "closed") {
                        $result_str .= "오전 휴무, ";
                    } else {
                        $result_str .= "오전 " . $this->plus_zero($value[0]) . ":" . $this->plus_zero($value[1]) . "~" . $this->plus_zero($value[2]) . ":" . $this->plus_zero($value[3]).", ";
                    }

                    if ($value[4] == "closed") {
                        $result_str .= "오후 휴무 입니다. ";
                    } else {
                        $result_str .= "오후 " . $this->plus_zero($this->after_none_value($value[4])) . ":" . $this->plus_zero($value[5]) . "~" . $this->plus_zero($this->after_none_value($value[6])) . ":" . $this->plus_zero($value[7]) . "까지 입니다.";
                    }

                    $now_time = strtotime(date("H:i", time()));
                    $morning_start = strtotime($this->plus_zero($value[0]) . ":" . $this->plus_zero($value[1]));
                    $morning_end = strtotime($this->plus_zero($value[2]) . ":" . $this->plus_zero($value[3]));
                    $after_start = strtotime($this->plus_zero($value[4]) . ":" . $this->plus_zero($value[5]));
                    $after_end = strtotime($this->plus_zero($value[6]) . ":" . $this->plus_zero($value[7]));
                    if ($morning_start < $now_time && $now_time < $morning_end) {
                        $now_chk_str = "현재 업무시간입니다.";
                    } else if ($after_start < $now_time && $now_time < $after_end) {
                        $now_chk_str = "현재 업무시간입니다.";
                    } else {
                        $now_chk_str = "현재 업무시간이 아닙니다.";
                    }
                }
            }
        }



        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'today_str' => $result_str,
            'now_str' => $now_chk_str,
        ])->render();
    }

    function plus_zero($my_value){
        if($my_value==0){
            return "00";
        }else if($my_value<10){
            return "0".$my_value;
        }else{
            return $my_value;
        }
    }

    function after_none_value($my_value){
        if($my_value>=12){
            return $my_value-12;
        }else{
            return $my_value;
        }
    }
}
