<?php
class Controller_Index extends WSL_Controller_ActionAbstract {
    public function indexAction() {
        $discover = new WSL_Soap_AutoDiscover('Service_Users');
        $discover->handle();
    }
    public function clientAction() {
        $client = new SoapClient('http://localhost/wanderson/wsl/?WSDL');
        var_dump($client->save());
    }
}

