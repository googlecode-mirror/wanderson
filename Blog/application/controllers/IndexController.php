<?php

/**
 * Controladora Principal do Aplicativo
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Blog
 * @package    Blog_Controller
 * @subpackage Action
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * Ação Principal do Aplicativo
     * @return void
     */
    public function indexAction()
    {
        $uri    = $this->getRequest()->getServer('REQUEST_URI');
        $script = $this->getRequest()->getServer('SCRIPT_NAME');
        if (strpos($uri, $script) === false) {
            $this->_redirect('/index.php');
        }
    }
}