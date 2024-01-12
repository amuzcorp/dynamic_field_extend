<?php
namespace Amuz\XePlugin\DynamicFieldExtend\DynamicFields\Questionnaire\Skins\Common;

use Overcode\XePlugin\DynamicFactory\Models\CptDocument;
use Overcode\XePlugin\DynamicFactory\Models\SuperRelate;
use Amuz\XePlugin\Vimeo\Models\VimeoDirectory;
use Xpressengine\DynamicField\AbstractSkin;
use Auth;

class CommonSkin extends AbstractSkin
{

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return '설문 문항 작성 필드 스킨';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field_extend::src/DynamicFields/Questionnaire/Skins/Common/views';
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
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args arguments
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        list($data, $key) = $this->filter($args);

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
        ])->render();
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

        $values = [];
        foreach ($this->getType()->getColumns() as $columnName => $columns) {
            $dataName = snake_case($this->config->get('id') . '_' . $columnName);
            if (isset($args[$dataName])) {
                $values[$dataName] = $args[$dataName];
            } else {
                $values[$dataName] = '';
            }
        }

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'values' => $values
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

        $cpt_ids = $this->config->get('cpt_ids');
        $ids = json_decode($data['ids']);

        $items = []; // CptDocument 가 들어감
        foreach($cpt_ids as $cpt_id) {
            foreach ((array)$ids as $id) {
                $item = CptDocument::division($cpt_id)->find($id);
                if ($item !== null) {
                    $items[] = $item;
                }
            }
        }

        $viewFactory = $this->handler->getViewFactory();
        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'items' => $items
        ])->render();
    }

    public function output($id, array $args)
    {
        $data = [];
        foreach ($this->getType()->getColumns() as $columnName => $columns) {
            $dataName = snake_case($id . '_' . $columnName);
            if (isset($args[$dataName])) {
                $data[$dataName] = $args[$dataName];
            } else {
                $data[$dataName] = '';
            }
        }
        if (count($data) == 0) {
            return null;
        }

        $output = implode($this->glue, $data);

        if (trim($output) == '') {
            return null;
        }

        return $output;
    }
}
