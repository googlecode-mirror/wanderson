<?php

/**
 * Controladora de Usuários
 *
 * @category Application
 * @package  Application_Controller
 */
class Controller_Users extends WSL_Controller_ActionAbstract {

    /**
     * Cliente SOAP
     * @var SoapClient
     */
    protected $_client = null;

    /**
     * Token de Conexão
     * @var string
     */
    protected $_token = null;

    /**
     * Acesso ao Cliente SOAP
     * @return SoapClient Elemento Solicitado
     */
    protected function _getClient() {
        // Inicializado?
        if ($this->_client === null) {
            // Inicialização
            $client = new SoapClient(null, array(
                'uri'      => 'tns:UsersService',
                'location' => 'http://localhost/wanderson/wsl/services/users',
            ));
            // Autenticar
            $token = $client->login('root@localhost', '7c4a8d09ca3762af61e59520943dc26494f8941b');
            // Configuração
            $this->_client = $client;
            $this->_token  = $token;
        }
        // Apresentação
        return $this->_client;
    }

    /**
     * Acesso ao Token de Autenticação
     * @return string Elemento Solicitado
     */
    protected function _getToken() {
        // Inicializado?
        if ($this->_token === null) {
            // Capturar o Cliente
            $this->_getClient(); // Grava o Token
        }
        // Apresentação
        return $this->_token;
    }

    /**
     * Ação Principal
     * @return null
     */
    public function indexAction() {
        // Parâmetros
        $client = $this->_getClient();
        $token  = $this->_getToken();
        // Captura de Usuários
        $users = $client->fetch($token);
        // Camada de Visualização
        $this->view->users = $users;
    }

}

