<?php

/**
 * @author Thiago Genuino
 */
class path {
    protected static function getCalled() {
        return get_called_class();
    }
    
    public static function base($add='') {
        return CORP_BASE_PUBLIC . DS . trim($add, '/');
    }
    
    public static function page($add='') {
        return CORP_BASE_PAGE . DS . trim($add, '/');
    }
    
    public static function pages($add='') {
        $class = self::getCalled();
        return $class::base('pages/'.$add);
    }
    
    public static function resources($add='') {
        $class = self::getCalled();
        return $class::base('resources/'.$add);
    }
    
    public static function js($add='') {
        $class = self::getCalled();
        return $class::resources('js/'.$add);
    }
    
    public static function css($add='') {
        $class = self::getCalled();
        return $class::resources('css/'.$add);
    }
}

?>
