<?php

/**
 * Plugin de Controladora para Módulo
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category   Acl
 * @package    Acl_Controller
 * @subpackage Plugin
 */
class Acl_Plugin_Module extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        // Verificação de Roteamento
        if ($request->getModuleName() == 'acl') {
            // Configurações Específicas
            // Layout
            $layout = Zend_Layout::startMvc();
            $layout->setLayout('layout.phtml')
                   ->setLayoutPath(dirname(__FILE__) . '/../layouts/scripts')
                   ->setInflectorTarget(':script');
            // View
            $view = $layout->getView();
            // JQuery
            ZendX_JQuery::enableView($view);
            $view->jQuery()->enable()
                ->setLocalPath($view->baseUrl('/js/jquery/jquery.js'));
        }
    }
}
