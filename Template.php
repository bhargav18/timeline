<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author bhargav
 */
class Template {
    private $args;
    private $file;

    public function __get($name) {
        return $this->args[$name];
    }

    public function __construct($file, $args = array()) {
        $this->file = $file;
        $this->args = $args;
    }

    public function out() {
        include $this->file;
    }
}

?>
