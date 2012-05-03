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
            'uri'      => 'tns:UsersService',
            'location' => 'http://localhost/wanderson/wsl/services/users',
        ));
        $email = 'root@localhost';
        $token = $client->login($email, '7c4a8d09ca3762af61e59520943dc26494f8941b');
        $users = $client->fetch($token);
        // Camada de Visualização
        $this->view->users = $users;
    }
}

