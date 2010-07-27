<?php

/**
 * 
 * Controladora de Erros
 * Recebe os Erros do Sistema Possibilitando Cadastro de Mensagens
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Controller
 * @see        http://code.google.com/p/wanderson/
 */
class ErrorController extends Zend_Controller_Action
{

    /**
     * 
     * Ação de Captura de Erros
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        if ($errors === null) {
            throw new Zend_Controller_Action_Exception('Invalid Access');
        }

        switch ($errors->type) {

            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Página Não Encontrada';
                break;

            default:
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Erro da Aplicação';
                break;
        }

        if ($log = $this->getLog()) {
            $log->crit($errors->exception->getMessage());
        }

        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
    }

    /**
     * 
     * Captura de Gravador de Informações
     * @return boolean|Zend_Log Objeto Responsável
     */
    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}
