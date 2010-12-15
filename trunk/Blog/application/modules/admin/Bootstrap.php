<?php

/**
 * Admin Bootstrap
 * Inicializador do Módulo de Administração
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Admin
 * @package  Admin_Bootstrap
 */
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initViewHelpers()
    {
        /* @var $front Zend_Controller_Front */
        $front = $this->getApplication()->getResource('FrontController');
        $front->registerPlugin(new Admin_Plugin_Controller());
    }

    public function _initRouters()
    {
        $front = $this->getApplication()->getResource('FrontController');
        $route = new Zend_Controller_Router_Route_Static('login', array(
            'module' => 'admin', 'controller' => 'auth', 'action' => 'login'
        ));
        $front->getRouter()->addRoute('login', $route);
    }
}