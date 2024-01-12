<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\CategoryLoad;

use App\Facades\XeCategory;
use Overcode\XePlugin\DynamicFactory\Models\CptDocument;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

use XeFrontend;
use View;
use Xpressengine\Database\VirtualConnectionInterface;
use XeConfig;
use Xpressengine\DynamicField\DynamicFieldExtendHandler;

use Xpressengine\Category\Models\Category as CategoryModel;

class CategoryLoadField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/CategoryLoad';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        //return 'Categoryload - 카테고리 불러오기';
        return 'Category load - 카테고리 불러오기';
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
//        return [
//            'column'=>new ColumnEntity('column', ColumnDataType::STRING)
//        ];
        return [
            'item_id' => (new ColumnEntity('item_id', ColumnDataType::STRING))->setParams([255]),
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        //return [];
        //return ['category_id' => 'required'];
        return ['category_load' => 'required'];
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
        $category = null;
        if ($config != null) {
            // for support version beta.26 before
            if ($config->get('category_id') == null && $config->get('categoryId') != null) {
                $config->set('category_id', $config->get('categoryId'));
            }
            $category = CategoryModel::find($config->get('category_id'));
        }

        $category_all = CategoryModel::all();

        XeFrontend::rule('dynamicFieldSection', $this->getSettingsRules());


        return view('dynamic_field_extend::src/DynamicFields/CategoryLoad/views/setting',         [
            'config' => $config,
            'category' => $category,
            'category_all'=>$category_all,
        ]);

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
            //var_dump($key);
            if (isset($args[$key]) == true) {
                $my_data = json_encode($args[$key]);
                $insertParam[$column->name] = $my_data;
                //$insertParam[$column->name] = $args[$key];
            }
        }
        //var_dump($insertParam);
        //exit;

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
                $my_data = json_encode($args[$key]);
                $insertParam[$column->name] = $my_data;
                //$insertParam[$column->name] = $args[$key];
            }
        }

        $this->handler->connection()->table($this->getRevisionTableName())->insert($insertParam);
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
        foreach ($this->getColumns() as $column) {
            $key = $config->get('id') . '_' . $column->name;

            if (isset($args[$key])) {
                $my_data = json_encode($args[$key]);
                $updateParam[$column->name] = $my_data;
                //$updateParam[$column->name] = $args[$key];
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
     * get dynamic field table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'field_' . 'xpressengine_category';
    }

    /**
     * get dynamic field revision table name
     *
     * @return string
     */
    public function getRevisionTableName()
    {
        return 'field_revision_' . 'xpressengine_category';
    }

    /**
     * 관리자 페이지 목록을 출력하기 위한 함수.
     * CPT 목록에만 해당하며, 필드타입자체에 추가해주어야한다.
     *
     * @param string $id dynamic field name
     * @param CptDocument $doc arguments
     * @return string|null
     */
    public function getSettingListItem($id, CptDocument $doc){
        $config = $this->config;
        $type = $this->handler->getRegisterHandler()->getType($this->handler, $config->get('typeId'));

        $args = $doc->getAttributes();
        $data = [];


        foreach ($type->getColumns() as $columnName => $columns) {
            $dataName = snake_case($id . '_' . $columnName);
            if (isset($args[$dataName])) {
//                dd(app('overcode.df.taxonomyHandler')->getCategoryItemsTree(json_dec($args[$dataName])));
                $data[$dataName] = xe_trans(CategoryItem::find(json_dec($args[$dataName]))->word);
            }
        }
        if (count($data) == 0) {
            return null;
        }

        return view('dynamic_field_extend::src/DynamicFields/CategoryInput/views/list-item',compact('id','data'));
    }
}
