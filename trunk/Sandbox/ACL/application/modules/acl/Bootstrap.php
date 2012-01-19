<?php

/**
 * Inicializador de Módulo
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category Acl
 * @package  Acl_Application
 */
class Acl_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * Inicialização de Plugins
     * @return null
     */
    protected function _initPlugins()
    {
        // Plugin de Módulo
        $plugin = new Acl_Plugin_Module();
        $this->bootstrap('frontcontroller')
             ->getResource('frontcontroller')->registerPlugin($plugin);
    }
}