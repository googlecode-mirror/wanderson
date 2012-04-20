<?php
class Controller_Index extends WSL_Controller_ActionAbstract {
    public function indexAction() {
        $discover = new WSL_Soap_AutoDiscover('Service_Users');
        if ($this->getRequest()->getParam('WSDL') !== null) {
            $this->view->discover = $discover;
            $this->getResponse()->setHeader('Content-Type', 'text/xml');
        } else {
            $server = new SoapServer($discover->getUri() . '?WSDL');
            $server->setClass('Service_Users');
            $server->handle();
        }
    }
    public function clientAction() {
        $client = new SoapClient('http://localhost/wanderson/wsl/?WSDL');
        var_dump($client->save());
    }
}

