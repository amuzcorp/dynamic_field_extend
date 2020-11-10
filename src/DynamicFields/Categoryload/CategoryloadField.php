<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Categoryload;

use App\Facades\XeCategory;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

use XeFrontend;
use View;
use Xpressengine\Database\VirtualConnectionInterface;
use XeConfig;
use Xpressengine\DynamicField\DynamicFieldHandler;

use Xpressengine\Category\Models\Category as CategoryModel;

class CategoryloadField extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/Categoryload';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Categoryload - 카테고리 불러오기';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'The fieldType supported by Dynamic_field_extend plugin.';
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
        return [];
        //return ['category_id' => 'required'];
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


        return view('dynamic_field_extend::src/DynamicFields/Categoryload/views/setting',         [
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

            if (isset($args[$key]) == true) {
                $insertParam[$column->name] = $args[$key];
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
}
