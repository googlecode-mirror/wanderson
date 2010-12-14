<?php

class Admin_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        if ($request->getModuleName() == 'admin') {
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout('admin');
            $navigation = $layout->getView()->navigation();
            $config = new Zend_Config_Xml(
                dirname(__FILE__) . '/../configs/navigation.xml');
            $navigation->addPages($config);
        }
    }
}