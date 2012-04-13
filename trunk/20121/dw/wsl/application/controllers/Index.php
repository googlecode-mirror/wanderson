<?php
class Controller_Index extends WSL_Controller_ActionAbstract {
    public function indexAction() {
        $controller = $this->getRequest()->getParam('a');
        var_dump($controller);
    }
}

