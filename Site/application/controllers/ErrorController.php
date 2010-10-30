<?php

/**
 * Controladora de Erros
 * 
 * Trabalha com o recebimento dos lançamentos de exceção do sistema, conforme
 * configurado na controladora frontal caso os erros sejam marcados como
 * tratáveis. Verifica acesso direto na ação principal de erros.
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @package Application
 * @subpackage Controller
 * @see http://code.google.com/p/wanderson/
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * Ação Principal de Tratamento de Erros
     * 
     * Todos os erros são enviados para esta ação que deve manipular o objeto de
     * exceção. Verificar acesso direto, evitando parâmetro inválido.
     * 
     * @throws Zend_Auth_Exception Acesso Proibido
     * @return void
     */
    public function errorAction()
    {
        /*
         * Requisição do Manipulador de Exceções
         * Verificação Correta de Acesso Indireto
         */
        $handler = $this->_getParam('error_handler', null);
        if ($handler === null) {
            /*
             * Acesso Direto Inválido
             * Usuário visitou a ação diretamente, sem gerar erros no sistema
             */
            throw new Zend_Auth_Exception('Forbidden', 403);
        }

        switch ($handler->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                /*
                 * Página Não Encontrada
                 */
                $code    = 404;
                $message = 'Página Não Encontrada';
                break;

            default:
                /*
                 * Verificação de Erro Interno ou Acesso Proibido
                 */
                if ($handler->exception->getCode() == 403) {
                    $code    = 403;
                    $message = 'Acesso Proibido';
                } else {
                    $code    = 500;
                    $message = 'Erro Interno do Aplicativo';
                }
        }

        /*
         * Configura o Código de Resposta HTTP
         */
        $this->getResponse()->setHttpResponseCode($code);

        /*
         * Envio de Valores para Camada de Ação
         */
        $this->view->code    = $code;
        $this->view->message = $message;
        $this->view->request = $handler->request;
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $handler->exception;
        }
    }
}