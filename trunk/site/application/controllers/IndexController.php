<?php

/**
 * 
 * Controladora Principal do Sistema
 * Tratamento de Acesso Sem Módulo de Reescrita do Apache
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Controller
 * @see        http://code.google.com/p/wanderson/
 */
class IndexController extends Zend_Controller_Action
{

    /**
     * 
     * Ação Principal do Sistema
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $uri     = $request->getServer('REQUEST_URI');
        $script  = $request->getServer('SCRIPT_NAME');
        if (strpos($uri, $script) === false) {
            $this->_redirect('/index.php');
        }
    }

}
