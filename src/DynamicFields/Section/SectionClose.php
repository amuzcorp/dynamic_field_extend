<?php

namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Section;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;

class SectionClose extends AbstractType
{

    protected static $path = 'dynamic_field_extend/src/DynamicFields/Section';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Close Section - 섹션 닫기';
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
        return view('dynamic_field_extend::src/DynamicFields/Section/views/settingClose');
    }



    public function get(DynamicQuery $query)
    {
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
