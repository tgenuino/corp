<?php
namespace app;

/**
 * @author Thiago Genuino
 */
abstract class template {
    protected $control;
    
    private     $_head = array(
                    'title' => 'Title',
                    'type' => 'text/html',
                    'charset' => 'utf-8',
                    'js' => array(),
                    'css' => array(),
                    'meta' => array()
                );
    
    public function __construct($ctl) {
        $this->control = $ctl;
        
        $this->_head('title', 'Corp');
        $this->_head('js', \url::base('resources/js/jquery.js'));
        $this->_head('js', \url::base('resources/js/corp.js'));
        $this->_head('css', \url::base('resources/css/main.css'));
        
        $this->init();
    }
    
    protected function getLevel($idx=null) {
        return $this->control->getRequest($idx);
    }
    
    public function init() {
        ?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->head() ?>
        
    </head>
    <body>
        <?php $this->body(); ?>
    </body>
</html>
        <?php
    }
    
    protected function head() {
        echo $this->_headParser();
    }
    
    protected function body() {
        
    }
    
    /**
     * Usage Types:
     * $this->_head('js', 'url_to/file.js')
     * $this->_head('css', 'url_to/file.css') -- Media?
     * $this->_head('meta', 'name', 'content')
     * $this->_head('type', 'text/html')
     * $this->_head('charset', 'utf-8')
     * $this->_head('title', 'Titulo')
     * 
     * $this->_head('title') -> 'Titulo'
     * 
     */
    public function _head() {
        $args = func_get_args();
        $mode = $args[0];
        
        if (!isset($args[1])) return $this->_head[$mode];
        
        $content = $args[1];
        
        switch($mode) {
            case 'js':
                $this->_head['js'][] = $content;
                break;
//                return '<script type="text/javascript" src="'.$content.'"></script>';
            case 'css':
                $this->_head['css'][] = $content;
                break;
            case 'meta':
                $this->_head['meta'][] = array($args[1], $args[2]);
                break;
//                return '<link href="'.$content.'" rel="stylesheet" type="text/css" />';
            default:
                $this->_head[$mode] = $content;
                break;
        }
        
        return $this;
    }
    
    private function _headParser() {
        $parsed = '<meta http-equiv="Content-Type" content="' . $this->_head('type') . '; charset=' . $this->_head('charset') . '">';
        
        // CSS
        foreach($this->_head['css'] as $css) {
            $parsed .= PHP_EOL . "\t\t" . '<link href="'.$css.'" rel="stylesheet" type="text/css" />';
        }
        
        // JS
        foreach($this->_head['js'] as $js) {
            $parsed .= PHP_EOL . "\t\t" . '<script type="text/javascript" src="'.$js.'"></script>';
        }
        
        // META
        foreach($this->_head['meta'] as $meta) {
            $parsed .= PHP_EOL . "\t\t" . '<meta name="'.$meta[0].'" content="'.$meta[1].'" />';
        }
        
        // TITLE
        foreach($this->_head['meta'] as $meta) {
            $parsed .= PHP_EOL . "\t\t" . '<title>' . $this('title') . '</title>';
        }
        
        return $parsed;
    }
}

?>
