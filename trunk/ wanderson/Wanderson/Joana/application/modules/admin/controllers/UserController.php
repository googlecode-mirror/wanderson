<?php
	class Admin_UserController extends System_Controller_Action {
		public function init() {
			parent::init();
			$toolbar = new System_Toolbar_User();
			$this->view->toolbar = $toolbar;
		}
		public function indexAction() {
			$options = array('rowClass' => 'Row_Identity');
			$table   = new Identity($options);
			$view    = new System_View();
			
			$view->users = $table->fetchAll(null, 'username ASC');
			$this->view->tabela = $view->render('tabela.phtml');
		}
		public function editAction() {
			$form = new System_Form_User();
			
			if($this->_request->isPost()) {
				$data = $this->_request->getPost();
				if($form->isValid($data)) {
					$data = $form->getValues();
					unset($data['submit']);
					$table = new Identity();
					$record = $table->find($data['id'])->current();
					if(is_null($record)) {
						unset($data['id']);
						$record = $table->createRow($data);
					}
					else {
						$data['username'] = $record->username;
						if($form->password->getUnfilteredValue() == '')
							$data['password'] = $record->password;
						$record->setFromArray($data);
					}
					try {
						$record->save();
						$this->_redirect('/admin/user');
					}
					catch(Zend_Db_Statement_Exception $e) {
						if(substr_count($e->getMessage(), 'identity_username_key'))
							$form->username->addError(System_Validate::IS_UNIQUE);
						else
							throw $e;
					}
				}
			}
			else {
				$filter = new System_Filter_PrimaryKey();
				$value  = $this->_request->getParam('id');
				$value  = $filter->filter($value);
				$table  = new Identity();
				$record = $table->find($value)->current();
				if(!is_null($record))
					$form->populate($record->toArray());
			}
			
			$this->view->form = $form;
		}
	}
