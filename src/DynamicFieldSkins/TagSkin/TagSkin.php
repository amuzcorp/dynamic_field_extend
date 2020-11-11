<?php
namespace Amuz\XePlugin\DynamicField\DynamicFieldSkins\TagSkin;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Tag\Tag;
use Xpressengine\Tag\TagRepository;
use Xpressengine\Plugins\Board\UrlHandler;

class TagSkin extends AbstractSkin
{
    protected static $loaded = false;

    public $urlHandler;

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        //return '해시태그 fieldSkin';
        return 'Tag default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamic_field::src.DynamicFieldSkins.TagSkin.views';
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

    public function create(array $args)
    {
        $viewFactory = $this->handler->getViewFactory();

        list($data, $key) = $this->filter($args);

        $args['scriptInit'] = false;
        if (self::$loaded === false) {
            self::$loaded = true;

            $args['scriptInit'] = true;
        }

        $args['strTags'] = '';

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field');

        return $viewFactory->make($this->getViewPath('create'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'config_dynamic'=>$config_dynamic,
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

        $viewFactory = $this->handler->getViewFactory();

        $tag_model = new TagRepository();
        $tag_data = "";
        if(isset($args['id'])) {
            $tag_data = $tag_model->fetchByTaggable($args['id'])->all();
        }
        //var_dump($tag_data);exit;
        $args['scriptInit'] = false;
        if (self::$loaded === false) {
            self::$loaded = true;

            $args['scriptInit'] = true;
        }

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field');
        return $viewFactory->make($this->getViewPath('show'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'item' => $tag_data,
            'config_dynamic'=>$config_dynamic,
        ])->render();
    }

    //AbstractSkin Class edit메서드 오버라이딩
    public function edit(array $args)
    {
        $tag_model = new TagRepository();
        $tag_data = $tag_model->fetchByTaggable($args['id'])->all();

        $args['strTags'] = '';
        if (is_array( $tag_data) && count( $tag_data) > 0) {
            $tagWords = [];
            foreach ( $tag_data as $tag) {
                $tagWords[] = $tag['word'];
            }
            $args['strTags'] = sprintf('["%s"]', implode('","', $tagWords));
        }

        $args['scriptInit'] = false;
        if (self::$loaded === false) {
            self::$loaded = true;

            $args['scriptInit'] = true;
        }

        list($data, $key) = $this->filter($args);
        //var_dump($args);exit;
        $viewFactory = $this->handler->getViewFactory();

        $configManager = app('xe.config');
        $config_dynamic = $configManager->get('dynamic_field');

        return $viewFactory->make($this->getViewPath('edit'), [
            'args' => $args,
            'config' => $this->config,
            'data' => array_merge($data, $this->mergeData),
            'key' => $key,
            'config_dynamic'=>$config_dynamic,
        ])->render();
    }


}
