<?php

class Admin_Plugin_Controller extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        if ($request->getModuleName() == 'admin') {
            $layout = Zend_Layout::getMvcInstance();
            if ($request->getControllerName() == 'auth'
                && $request->getActionName() == 'login') {
                $layout->setLayout('login');
            } else {
                $auth = Zend_Auth::getInstance();
                if (!$auth->hasIdentity()) {
                    $request->setControllerName('auth')->setActionName('login');
                    $layout->setLayout('login');
                } else {
                    $layout->setLayout('admin');
                    $navigation = $layout->getView()->navigation();
                    $config = new Zend_Config_Xml(
                        dirname(__FILE__) . '/../configs/navigation.xml');
                    $navigation->addPages($config);
                }
            }
        }
    }
}