<?php
class WSL_Controller_Front {
    private static $_instance = null;
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function __construct() {}
    public function dispatch() {}
}

