<?php

/**
 * Inicializador do Aplicativo
 * 
 * Nesta classe devem ser desenvolvidos os métodos que são inicializados em
 * tempo de construção do aplicativo. Configurações que são necessárias em todo
 * o ambiente de execução devem ser inseridas neste local, utilizando a notação
 * conforme documentação do Zend Framework
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @package Application
 * @subpackage Bootstrap
 * @see http://code.google.com/p/wanderson/
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Rotas do Sistema
     * 
     * Insere novas rotas do sistema, tentando modificar os parâmetros
     * solicitados para novos caminhos mais fáceis de identificar pelo usuário
     * 
     * @return void
     */
    public function _initRoutes()
    {
        /*
         * Requisição de Início da Controladora
         * Objeto de Tratamento de Rotas do Sistema
         */
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $router = $front->getRouter();

        /*
         * Rota para Descrição do Aplicativo
         */
        $route = new Zend_Controller_Router_Route_Static('sobre',
            array('controller' => 'index', 'action' => 'sobre')
        );
        $router->addRoute('sobre', $route);
    }
}