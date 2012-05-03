<?php

/**
 * Controladora de Serviços
 *
 * @category Application
 * @package  Application_Controller
 */
class Controller_Services extends WSL_Controller_ActionAbstract {

    /**
     * Execução de Serviço
     *
     * Construção de Serviços para determinados elementos do sistema, utilizando
     * ações nesta controladora para acesso. Esta inicialização deve ser
     * efetuada somente uma vez por requisição.
     *
     * @param  string $element Nome do Serviço para Execução
     * @return null
     */
    protected function _execute($element) {
        // Desabilitar Layout
        WSL_Controller_Front::getInstance()
            ->getConfig()->setParam('Layout.enabled', false);
        // Inicialização
        $service = new SoapServer(null, array(
            'uri' => 'tns:' . $element . 'Service',
        ));
        // Configurar Classe
        $service->setClass('Service_' . $element);
        // Tratamento de Requisição
        try {
            $service->handle();
        } catch (Exception $e) {
            // Tratamento de Erro
            $service->fault('Server', $e->getMessage());
        }
    }

    /**
     * Serviço de Usuários
     * @return null
     */
    public function usersAction() {
        // Acesso ao Serviço
        $this->_execute('Users');
    }

}

