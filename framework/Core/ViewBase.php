<?php
namespace framework\Core;
use framework\Helpers\Request;
use framework\Helpers\Tpl;

/**
 * Class ViewBase
 * @package framework\Core
 */
class ViewBase
{
    /**
     * @var string
     */
    private $viewPath = FW . DS . 'Views';
    /**
     * @var string
     */
    private $ext = '.php';
    /**
     * @var array
     */
    protected $baseScripts = [
        'bootstrap.min',
        'ie10-viewport-bug-workaround',
    ];
    /**
     * Seo title
     * @var
     */
    protected $title;

    public function __construct()
    {
        $this->title = 'The Bee Game';
        Tpl::includeCSS($this->baseScripts);
        Tpl::includeJS($this->baseScripts);
    }

    /**
     * @param $contentView
     * @param string $templateView
     * @param null $data
     */
    public function generate($contentView, $data = null, $templateView = 'main')
    {
        Tpl::includeCSS(['cover', 'style']);
        if(is_array($data)) {
            extract($data);
        }
        $contentView .= $this->ext;
        if (is_dir($this->viewPath . DS . Request::getController())) {
            $contentView = $this->viewPath . DS . Request::getController() . DS . $contentView;
        }

        require $this->viewPath . DS . 'layouts' . DS . $templateView . $this->ext;
    }

    /**
     * @param $contentView
     * @param null $data
     * @return string
     */
    public function render($contentView, $data = null)
    {
        if(is_array($data)) {
            extract($data);
        }
        $contentView .= $this->ext;
        if (is_dir($this->viewPath . DS . Request::getController())) {
            $contentView = $this->viewPath . DS . Request::getController() . DS . $contentView;
        }
        ob_start();
        require $contentView;
        $template = ob_get_contents();
        ob_get_clean();

        return $template;
    }
}
