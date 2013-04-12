<?php
namespace app;

define('DS', (DIRECTORY_SEPARATOR == '\\' ? '/' : DIRECTORY_SEPARATOR));

/**
 * @author Thiago Genuino
 */
class corp {
    protected   $_request,
                $_base;
    
    final public static function start($uri, $dir) {
        $app = new self($uri, $dir);
        return $app->router()->init();
    }
    
    final public static function autoload($cn) {
        $cn = str_replace('\\', DS, $cn);
        
        $file = __DIR__ . DS . '..' . DS . $cn . '.php';
        
        if (is_file($file)) {
            require($file);
        }
    }
    
    final private function __construct($uri, $dir) {
        $this->_base = str_replace('\\', DS, $dir);
        
        if (!defined('CORP_URL')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $appbase = str_replace($root, '', $this->_base);
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . trim($appbase, '/');
            define('CORP_URL', $url);
        }
        
        if (!defined('CORP_BASE_PUBLIC'))
            define('CORP_BASE_PUBLIC', $this->_base);
        
        $called = get_called_class();
        if ($called != 'app\\corp') {
            define('CORP_BASE_PAGE', dirname(str_replace('\\', DS, CORP_BASE_PUBLIC . DS . $called)));
            define('CORP_URL_PAGE', dirname(CORP_URL . DS . str_replace('\\', DS, $called)));
        }
            
        if (!is_array($uri)) $this->_request = explode('/', trim(str_replace($appbase, '', $uri), '/'));
            else $this->_request = $uri;
    }
    
    protected function init() {
        $this->render('home');
    }
    
    public function getRequest($idx=null) {
        $req = $this->_request;
        
        if (!isset($idx)) return $req;
        
        $max = count($req);
        if ($idx < 0) {
            $idx = $max + ($idx);
            if ($idx < 0) return null;
        } else {
            if ($idx >= $max) return null;
        }
        
        return $req[$idx];
    }
    
    protected function render($tpl) {
        $classe = '\\pages\\'.$tpl;
        $obj = new $classe($this);
        
        return $obj;
    }
    
    protected function router() {
        $req = $this->_request;
        $p = array();
        
        while(!empty($req)) {
            $classe = '\\control\\'.implode('\\', $req);
            $test = implode(DS, $req) . '.php';
            if (is_file(\path::base('control/'.$test))) {
                return new $classe(array_reverse($p), $this->_base);
            }
            $p[] = end($req);
            $req = array_slice($req, 0, -1);
        }
        
        $ctl = new \control\home($this->_request, $this->_base);
        return $ctl;
    }

}

spl_autoload_register(array(__NAMESPACE__.'\\corp', 'autoload'));

?>
