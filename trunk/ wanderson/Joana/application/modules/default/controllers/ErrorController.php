<?php
	class ErrorController extends System_Controller_Action {
		public function errorAction() {
			/* Captura de Erro Gerado */
			$error = $this->_getParam('error_handler');
			/* Acesso Externo */
			if(is_null($error))
				$this->_redirect('/');
			/* Gravação no Banco de Dados */
			$config = Zend_Registry::get('config');
			$id = null;
			if($config->error->save)
				$id = $this->saveError($error);
			/* Controller */
			switch($error->type) {
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
				case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
					$titulo = 'Página não encontrada!';
					break;
				default:
					$titulo = 'Erro Interno!';
			}
			/* View */
			$this->view->titulo = $titulo;
			$this->view->pagina = $error->request->getRequestUri();
			$this->view->id     = $id;
		}
		
		/**
		 * Salva o erro informado no banco de dados,
		 * verificando se o mesmo já não existe.
		 * @return int Identificador do erro no banco de dados.
		 * @param ArrayObject $error
		 */
		private function saveError(ArrayObject $error) {
			$table    = new Error();
			$message  = $table->getAdapter()->quoteInto('message = ?', $error->exception->getMessage());
			$fixed    = $table->getAdapter()->quoteInto('fixed = ?', 'false');
			$record   = $table->fetchRow(array($message,$fixed));
			if(is_null($record)) {
				$record = $table->createRow();
				$record->identity   = Zend_Auth::getInstance()->getIdentity()->username;
				$record->ip         = $error->request->getServer('REMOTE_ADDR');
				$record->uri        = $error->request->getRequestUri();
				$record->message    = $error->exception->getMessage();
				$record->file       = $error->exception->getFile();
				$record->line       = $error->exception->getLine();
				$record->serialized = serialize($error);
				$record->save();
			}
			return $record->id;
		}
	}
