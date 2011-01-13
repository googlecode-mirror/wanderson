<?php

/**
 * Controladora de Erros do Aplicativo
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Blog
 * @package    Blog_Controller
 * @subpackage Action
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * Ação para Tratamento de Erros Gerados
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // Erro 404 Página Não Encontrada
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Página Não Encontrada';
                break;

            default:
                // Erro 500 Erro Interno do Aplicativo
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Erro Interno';
                break;
        }

        $logger = Hazel_Log::getInstance();
        $logger->crit($errors->exception->getMessage(), $errors->exception);

        if ($this->getInvokeArg('displayExceptions')) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
    }
}