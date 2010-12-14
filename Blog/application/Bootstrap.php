<?php

/**
 * Inicializador do Sistema
 * 
 * Configurações necessárias para que o sistema seja executado corretamente. Se
 * estes dados geram algum erro, provavelmente o sistema não deve ser
 * inicializado e devemos atirar exceções para tratamento superior.
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @package Application
 * @subpackage Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Configuração Básica de Auxiliares da Camada de Visualiação
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
        $doctype->setDoctype(Zend_View_Helper_Doctype::XHTML1_STRICT);
        /* @var $headTitle Zend_View_Helper_HeadTitle */
        $headTitle = $view->headTitle();
        $headTitle
            ->headTitle('Wanderson Camargo')
            ->setSeparator(' > ');
        /* @var $headMeta Zend_View_Helper_HeadMeta */
        $headMeta = $view->headMeta();
        $headMeta
            ->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
            ->appendHttpEquiv('Content-Language', 'pt-BR');
    }
}