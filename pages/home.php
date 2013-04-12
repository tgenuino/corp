<?php
namespace pages;

/**
 * @author Thiago Genuino
 */
class home extends \app\template {
    function head() {
        $this->_head('css', \url::css('home.css'));
        
        parent::head();
    }
    
    function body() {
        print_r($this->getLevel());
    }
}

?>
