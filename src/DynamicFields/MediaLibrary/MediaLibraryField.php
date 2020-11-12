<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\MediaLibrary;

use App\Facades\XeStorage;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Illuminate\Database\Schema\Blueprint;

class MediaLibraryField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/MediaLibrary';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Media library - 미디어 라이브러리';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '미디어 라이브러리 by Dynamic_field plugin.';
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
        return view('dynamic_field_extend::src/DynamicFields/MediaLibrary/views/setting');
    }

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

    public function insert(array $args){
        $config = $this->config;

        if (isset($args[$config->get('joinColumnName')]) === false) {
            throw new RequiredJoinColumnException;
        }

        $insertParam = [];
        $insertParam['field_id'] = $config->get('id');
        $insertParam['target_id'] = $args[$config->get('joinColumnName')];
        $insertParam['group'] = $config->get('group');

        //$file = XeStorage::find("60644b79-88d8-472c-a6b8-09c14cc1a755");
        //var_dump($file->path);exit;

        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key]) == true) {
                $insertParam[$column->name] = json_encode($args[$key]);
            }
        }
        //$my_json = json_encode($insertParam['column']);
        //var_dump( json_encode($insertParam['column']));
        //var_dump( json_decode($my_json, true));
        //exit;

        if(isset($insertParam['column'])){
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

    public function insertRevision(array $args)
    {
        if (isset($args['id']) === false) {
            throw new RequiredDynamicFieldExtendException;
        }

        $insertParam = [];
        $insertParam['target_id'] = $args['id'];
        $insertParam['group'] = $this->config->get('group');
        $insertParam['field_id'] = $this->config->get('id');
        $insertParam['revision_id'] = $args['revision_id'];
        $insertParam['revision_no'] = $args['revision_no'];

        foreach ($this->getColumns() as $column) {
            $key = $this->config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $insertParam[$column->name] = json_encode($args[$key]);
            }
        }

        if(isset($insertParam['column'])) {
            $this->handler->connection()->table($this->getRevisionTableName())->insert($insertParam);
        }
    }

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
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $updateParam[$column->name] = json_encode($args[$key]);
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

    /**
     * 생성된 Dynamic Field 테이블에 데이터 삭제
     *
     * @param array $wheres Illuminate\Database\Query\Builder's wheres attribute wheres attribute
     * @return void
     */
    public function delete(array $wheres)
    {
        $config = $this->config;
        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));
        $where = $this->getWhere($wheres, $config);

        if (isset($where['target_id']) === false) {
            throw new RequiredDynamicFieldExtendException;
        }

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.before_delete', $config->get('group'), $config->get('id'))
        );

        $this->handler->connection()->table($type->getTableName())->where($where)->delete();

        // event fire
        $this->handler->getRegisterHandler()->fireEvent(
            sprintf('dynamicField.%s.%s.after_delete', $config->get('group'), $config->get('id'))
        );
    }


}
