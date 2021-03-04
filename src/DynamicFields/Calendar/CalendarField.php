<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Calendar;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;

class CalendarField extends AbstractType
{
    protected static $path = 'dynamic_field_extend/src/DynamicFields/CalendarField';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Calendar - 날짜 선택';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '날짜를 선택하여 입력 할 수 있습니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'start' => new ColumnEntity('start', ColumnDataType::TEXT),
            'end' => new ColumnEntity('end', ColumnDataType::TEXT)
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['date_type' => 'required'];
    }

    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getSettingsView(ConfigEntity $config = null)
    {
        return view('dynamic_field_extend::src/DynamicFields/Calendar/views/setting', [
            'config' => $config
        ]);
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        $required = $this->config->get('required') === true;

        $rules = [];
        $names = array_map(function () {
            return '';
        }, $this->getColumns());

        if($this->config->get('date_type') == 'single'){
            $names = ['start' => ''];
        }

        foreach (array_merge($names, $this->rules) as $name => $rule) {
            $key = $this->config->get('id') . '_' . $name;

            if ($required == true) {
                $rules[$key] = ltrim($rule . '|required', '|');
            } else {
                $rules[$key] = 'nullable|' . $rule;
            }
        }

        return $rules;
    }
}
