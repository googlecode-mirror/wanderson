<?php
class Controller_Index extends WSL_Controller_ActionAbstract {
    public function indexAction() {
        $discover = new WSL_Soap_AutoDiscover('Service_Users');
        $this->getResponse()->setHeader('Content-Type', 'application/xml');
        $this->view->discover = $discover;
    }
}

