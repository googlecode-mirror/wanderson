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
        /* @var $front Zend_Controller_Front */
        $front = $this->getResource('FrontController');
        /* @var $router Zend_Controller_Router_Abstract */
        $router = $front->getRouter();

        /*
         * Rota para Descrição do Aplicativo
         */
        $route = new Zend_Controller_Router_Route_Static('sobre',
            array('controller' => 'index', 'action' => 'sobre')
        );
        $router->addRoute('sobre', $route);
    }

    /**
     * Auxiliares da Camada de Visualização
     * 
     * Configura os métodos auxiliares da camada de visualização para
     * renderização automática de elementos como título ou metadados
     * 
     * @return void
     */
    public function _initViewHelpers()
    {
        /* @var $layout Zend_Layout */
        $layout = $this->bootstrap('Layout')->getResource('Layout');
        $view = $layout->getView();

        /* @var $doctype Zend_View_Helper_Doctype */
        $doctype = $view->doctype();
        $doctype->doctype(Zend_View_Helper_Doctype::XHTML1_STRICT);

        /* @var $headTitle Zend_View_Helper_HeadTitle */
        $headTitle = $view->headTitle();
        $headTitle->setIndent(4)->setSeparator(' > ')
            ->headTitle('Wanderson Camargo');

        /* @var $headMeta Zend_View_Helper_HeadMeta */
        $headMeta = $view->headMeta();
        $headMeta->setIndent(4)
            ->appendHttpEquiv('Content-type', 'text/html;charset=UTF-8')
            ->appendHttpEquiv('Content-Language', 'pt-BR');
    }
}