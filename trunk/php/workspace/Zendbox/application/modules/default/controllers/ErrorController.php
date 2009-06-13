<?php
	class ErrorController extends System_Controller_Action {
		public function indexAction() {
			$this->_redirect('/');
		}
		public function errorAction() {
			$error = $this->_getParam('error_handler');
			$mensagem = '';
			switch($error->type) {
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
					$message = 'Página não encontrada!';
					break;
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
					$message = 'Erro interno de processamento!';
					break;
				default:
					$message = 'Erro desconhecido';
			}
			$this->view->message = $message;
		}
	}
