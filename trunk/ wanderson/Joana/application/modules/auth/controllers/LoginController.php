<?php
	class Auth_LoginController extends System_Controller_Action {
		public function init() {
			parent::init();
			$this->view->layout()->setLayout('login');
		}
		public function indexAction() {
			/* Autenticado */
			$auth = Zend_Auth::getInstance();
			if($auth->hasIdentity())
				$this->_redirect('/');
			
			$form = new System_Form_Login();
			
			if($this->_request->isPost()) {
				$data = $this->_request->getPost();
				if($form->isValid($data)) {
					$values = $form->getValues();
					
					$database = Zend_Db_Table::getDefaultAdapter();
					
					$adapter = new Zend_Auth_Adapter_DbTable($database);
					$adapter
					->setTableName('identity')
					->setIdentityColumn('username')
					->setCredentialColumn('password')
					->setIdentity($values['username'])
					->setCredential($values['password']);
					
					$result = $auth->authenticate($adapter);
					$info = $adapter->getResultRowObject(null, 'password');
					if($result->isValid() && $info->allowed) {
						$table = new Role();
						$role  = $table->find($info->fkrole)->current();
						$info->role = (object) $role->toArray();
						$auth->getStorage()->write($info);
						$this->_redirect('/');
					}
					else
						$auth->clearIdentity();
				}
				$form->addError('Falha de Autenticação');
			}
			
			$this->view->form = $form;
		}
		public function blockedAction() {
			$auth   = Zend_Auth::getInstance();
			$auth->clearIdentity();
			$config = Zend_Registry::get('config');
			if(!$config->auth->blocked)
				$this->_redirect('/auth/logout');
		}
	}
