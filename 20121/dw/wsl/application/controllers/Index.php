<?php

/**
 * Controladora Principal
 *
 * @category Application
 * @package  Application_Controller
 */
class Controller_Index extends WSL_Controller_ActionAbstract {

    /**
     * Ação Principal
     * @return null
     */
    public function indexAction() {
        // Inicialização
        $client = new SoapClient(null, array(
            'uri' => 'tns:UsersService',
            'location' => 'http://localhost/wanderson/wsl/users/service/',
        ));
        $users = $client->fetch();
        // Camada de Visualização
        $this->view->users = $users;
    }
}

