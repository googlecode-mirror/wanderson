<?php
class Controller_Index extends WSL_Controller_ActionAbstract {
    public function indexAction() {
        $discover = new WSL_Soap_Server('Service_Users');
        $discover->handle();
    }
    public function clientAction() {
        $router = WSL_Controller_Front::getInstance()->getRouter();
        $client = new SoapClient($router->getServerUrl() . $router->url(array(
            'action' => 'index',
        )) . '?WSDL');
        var_dump($client->save());
    }
}

