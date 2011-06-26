<?php

/**
 * Error Controller
 *
 * @category Application
 * @package  Application_Controller
 */
class ErrorController extends Zend_Controller_Action
{

    /**
     * Error Action
     */
    public function errorAction()
    {
        // Error Handler
        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Página Não Encontrada';
                break;

            default:
                // 500
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Erro Interno';
                break;
        }

        // Log
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }

        // Display Errors
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request   = $errors->request;
    }

    /**
     * Log
     * @return Zend_Log|null
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
