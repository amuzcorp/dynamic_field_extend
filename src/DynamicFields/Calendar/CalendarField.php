<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Calendar;

use Carbon\Carbon;
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
            'start' => new ColumnEntity('start', ColumnDataType::TIMESTAMP),
            'end' => new ColumnEntity('end', ColumnDataType::TIMESTAMP)
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

    /**
     * 생성된 Dynamic Field 테이블에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insert(array $args)
    {
        $config = $this->config;

        if (isset($args[$config->get('joinColumnName')]) === false) {
            throw new Exceptions\RequiredJoinColumnException;
        }
        $insertParam = [];
        $insertParam['field_id'] = $config->get('id');
        $insertParam['target_id'] = $args[$config->get('joinColumnName')];
        $insertParam['group'] = $config->get('group');

        $dateTime_data = $this->setDateTimeData($config, $args);

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;
            if (isset($args[$key]) == true) {
                $insertParam[$column->name] = $dateTime_data[$column->name];
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_insert', $config->get('group'), $config->get('id'))
        );

        if (count($insertParam) > 1) {
            $this->handler->connection()->table($this->getTableName())->insert($insertParam);
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_insert', $config->get('group'), $config->get('id'))
        );
    }

    /**
     * 생성된 Dynamic Field 테이블에 데이터 수정
     *
     * @param array $args   parameters
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres)
    {
        $config = $this->config;
        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));

        $where = $this->getWhere($wheres, $config);

        if (isset($where['target_id']) === false) {
            return null;
        }

        foreach ($args as $index => $arg) {
            if ($arg == null) {
                $args[$index] = '';
            }
        }

        $updateParam = [];
        $dateTime_data = $this->setDateTimeData($config, $args);
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;
            if (isset($args[$key]) == true) {
                $updateParam[$column->name] = $dateTime_data[$column->name];
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_update', $config->get('group'), $config->get('id'))
        );

        if (count($updateParam) > 0) {
            if ($this->handler->connection()->table($type->getTableName())
                    ->where($where)->first() != null
            ) {
                $this->handler->connection()->table($type->getTableName())
                    ->where($where)->update($updateParam);
            } else {
                $insertParam = $updateParam;
                $insertParam['target_id'] = $where['target_id'];
                $insertParam['field_id'] = $config->get('id');
                $insertParam['group'] = $config->get('group');

                $this->handler->connection()->table($type->getTableName())
                    ->insert($insertParam);
            }
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_update', $config->get('group'), $config->get('id'))
        );
    }

    private function setDateTimeData($config, $args) {

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;
            if (isset($args[$key]) == true) {
                $date = $args[$key][0];
                $time = $args[$key][1];

                $dateTime[$column->name] = $date;
                $dateTime[$column->name.'_time'] = $time;

                if($config->get('picker_type') === 'date') {
                    if($column->name === 'start') {
                        $dateTime[$column->name.'_time'] = '00:00';
                    } elseif($column->name === 'end') {
                        $dateTime[$column->name.'_time'] = '23:59';
                    }
                }
                if($config->get('date_type') == 'single') {
                    if($column->name === 'end') {
                        $dateTime[$column->name] = $dateTime['start'];
                    }
                }
                if($config->get('time_type') == 'single') {
                    if($column->name === 'end_time') {
                        $dateTime[$column->name.'_time'] = $dateTime['start_time'];
                    }
                }
            }
        }

        $start_dateTime = $dateTime['start'].' '.$dateTime['start_time'].':00';
        $end_dateTime = $dateTime['end'].' '.$dateTime['end_time'].':00';
        $start = Carbon::createFromFormat('Y-m-d H:i:s', $start_dateTime);
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $end_dateTime);

        return compact('start', 'end');
    }

}
