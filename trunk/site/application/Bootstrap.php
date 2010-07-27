<?php

/**
 * 
 * Inicializador do Aplicativo
 * Configura a Visualização do Sistema para Formatação e Estilo
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Bootstrap
 * @see        http://code.google.com/p/wanderson/
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * 
     * Inicialização dos Auxiliares da Camada de Visualização
     * @return void
     */
    protected function _initViewHelpers()
    {
        $layout = $this->bootstrap('Layout')->getResource('Layout');
        $view   = $layout->getView();
        Zend_Dojo::enableView($view);
        $view->dojo()->enable()->setDjConfigOption('locale', 'pt-br')
            ->setCdnVersion('1.5');
        $view->headTitle('Wanderson');
        $view->doctype(Zend_View_Helper_Doctype::XHTML1_STRICT);
        $view->headMeta()
            ->appendHttpEquiv('Content-Type','text/html; charset=UTF-8');
    }
}
