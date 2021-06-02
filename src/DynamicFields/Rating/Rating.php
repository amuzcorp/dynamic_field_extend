<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Rating;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class Rating extends AbstractType
{
    protected static $path = 'dynamic_field_extend/src/DynamicFields/Rating';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Number 평점계산';
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
        $field_list = \DB::table('config')->select(\DB::raw('SubString_Index(name , "." , -1) as field_id'))->where('site_key',\XeSite::getCurrentSiteKey())->where('vars','like','%"skinId":"fieldType\\\\/xpressengine@Number\\\\/fieldSkin\\\\/dynamic_field_extend@RatingStar"%')->pluck('field_id');
        return view('dynamic_field_extend::src/DynamicFields/Rating/views/setting',['field_list' => $field_list]);
    }

    /**
     * 이 다이나믹필드는 number를 같이쓴다.
     *
     * @return string
     */
    public function getTableName()
    {
        return 'field_xpressengine_number';
    }

    /**
     * $query 에 inner join 된 쿼리를 리턴
     *
     * @param DynamicQuery $query query builder
     * @return Builder
     */
    public function get(DynamicQuery $query)
    {
        if ($this->checkExistTypeTables() == false) return $query;

        $config = $this->config;
        if (($config->get('sortable') === false && $config->get('searchable') === false) || $config->get('use') === false || $config->get('target_field_id') == null) {
            return $query;
        }
        $baseTable = $query->from;

        $type = $this->handler->getRegisterHandler()->getType($this->handler, 'fieldType/xpressengine@Number');
        $tablePrefix = $this->handler->connection()->getTablePrefix();

        $createTableName = $type->getTableName();
        if ($query->hasDynamicTable($config->get('group') . '_' . $config->get('id')) === true) {
            return $query;
        }

        $rawString = sprintf('%s.*', $tablePrefix . $baseTable);
        $key = $config->get('id') . '_avg';
        $rawString .= sprintf(', avg(%s.%s) as %s', $tablePrefix . $config->get('id'), 'num', $key);

        $query->leftJoin('comment_target',
            function (JoinClause $join) use ($createTableName, $config, $baseTable) {
                $join->on('documents.id','=','comment_target.target_id');
            }
        )->selectRaw($tablePrefix.'comment_target.doc_id');

        $query->leftJoin(
            sprintf('%s as %s', $createTableName, $config->get('id')), // number as rating_avg
            function (JoinClause $join) use ($createTableName, $config, $baseTable) {
                $join->on('comment_target.doc_id','=',sprintf('%s.target_id', $config->get('id'))
                )->where($config->get('id') . '.field_id', $config->get('target_field_id'));
            }
        )->selectRaw($rawString);
        $query->setDynamicTable($config->get('group') . '_' . $config->get('id'));
        $query->groupBy('documents.id');

        return $query;
    }

    public function insert(array $args)
    {

    }

    public function insertRevision(array $args)
    {

    }

    public function update(array $args, array $wheres)
    {

    }
}
