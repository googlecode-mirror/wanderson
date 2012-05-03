<?php

/**
 * Controladora de Usuários
 *
 * @category Application
 * @package  Application_Controller
 */
class Controller_Users extends WSL_Controller_ActionAbstract {

    /**
     * Acesso ao Serviço
     * @return null
     */
    public function serviceAction() {
        // Desabilitar Layout
        WSL_Controller_Front::getInstance()
            ->getConfig()->setParam('Layout.enabled', false);
        // Inicialização
        $service = new SoapServer(null, array(
            'uri' => 'tns:UsersService',
        ));
        // Configurar Classe
        $service->setClass('Service_Users');
        // Tratamento de Requisição
        try {
            $service->handle();
        } catch (Exception $e) {
            // Tratamento de Erro
            $service->fault('Server', $e->getMessage());
        }
    }

}

