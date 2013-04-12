<?php

/**
 * @author Thiago Genuino
 */
class url extends path {
    public static function base($add='') {
        return CORP_URL . '/' . $add;
    }
    
    public static function page($add='') {
        return CORP_URL_PAGE . '/' . $add;
    }
}

?>
