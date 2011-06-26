<?php

/**
 * Bootstrap
 * 
 * @category Application
 * @package  Application_Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Inicialização de Auxiliares da Visualização
     * @return null
     */
    protected function _initViewHelpers()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');

        /* @var $view Zend_View */
        $view = $layout->getView();
        // Doctype
        $view->doctype(Zend_View_Helper_Doctype::XHTML1_STRICT);
        // Meta
        $view->headMeta()
             ->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
        // Link
        $view->headLink()
             ->appendStylesheet('/js/dojo/resources/dojo.css');
        // Title
        $view->headTitle('Sistema de Artigos')->setSeparator(' - ');
        // Dojo Toolkit
        Zend_Dojo::enableView($view);
        $view->dojo()
             ->setLocalPath('/js/dojo/dojo.js')
             ->addStylesheetModule('dijit.themes.claro');
    }

    /**
     * Inicialização da Navegação no Sistema
     * @return null
     */
    protected function _initSystemNavigation()
    {
        // Arquivo de Configuração
        $filename = realpath(APPLICATION_PATH . '/configs/navigation.xml');
        $config   = new Zend_Config_Xml($filename);

        // Navegação
        $navigation = new Zend_Navigation($config);
        $layout = $this->bootstrap('layout')->getResource('layout');
        $layout->getView()->getHelper('navigation')->setContainer($navigation);
    }
}