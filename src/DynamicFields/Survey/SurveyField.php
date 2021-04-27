<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Survey;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Illuminate\Database\Schema\Blueprint;

class SurveyField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/Survey';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Survey editor- 설문조사 에디터';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'The fieldType supported by Dynamic_field plugin.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'column'=>new ColumnEntity('column', ColumnDataType::STRING)
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
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
        return view('dynamic_field_extend::src/DynamicFields/Edittable/views/setting');
    }

    /**
     * create dynamic field tables
     *
     * @return void
     */
    public function createTypeTable()
    {
        $self = $this;

        //일반 테이블 생성
        if ($this->checkExistTable($this->getTableName()) == false) {
            $this->handler->connection()->getSchemaBuilder()->create(
                $this->getTableName(),
                function (Blueprint $table) use ($self) {
                    $table->string('field_id', 36);
                    $table->string('target_id', 36);
                    $table->string('group');
                    $table->text('column');

//                    foreach ($self->getColumns() as $column) {
//                        $column->add($table, '');
//                    }

                    $table->index(['field_id', 'target_id', 'group'], 'index');
                }
            );
        }

        //revision 테이블 생성
        if ($this->checkExistTable($this->getRevisionTableName()) == false) {
            $this->handler->connection()->getSchemaBuilder()->create(
                $this->getRevisionTableName(),
                function (Blueprint $table) use ($self) {
                    $table->string('revision_id', 255);
                    $table->integer('revision_no')->default(0);
                    $table->string('field_id', 36);
                    $table->string('target_id', 36);
                    $table->string('group');
                    $table->text('column');

//                    foreach ($self->getColumns() as $column) {
//                        $column->add($table, '');
//                    }

                    $table->primary(array('revision_id', 'field_id'), 'primaryKey');
                    $table->index(['field_id', 'target_id', 'group'], 'index');
                }
            );
        }
    }

    /**
     * check exist table by table name
     *
     * @param string $tableName check table name
     *
     * @return mixed
     */
    private function checkExistTable($tableName)
    {
        return $this->handler->connection()->getSchemaBuilder()->hasTable($tableName);
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
            throw new RequiredJoinColumnException;
        }

        $insertParam = [];
        $insertParam['field_id'] = $config->get('id');
        $insertParam['target_id'] = $args[$config->get('joinColumnName')];
        $insertParam['group'] = $config->get('group');

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key]) == true) {
                $insertParam[$column->name] = $args[$key];
                //var_dump($args[$key]);exit;
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
}
