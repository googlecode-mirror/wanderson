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
    }
}
