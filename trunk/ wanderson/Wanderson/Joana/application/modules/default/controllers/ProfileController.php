<?php
	class ProfileController extends System_Controller_Action {
		public function indexAction() {
			$form = new System_Form_Profile();
			
			if($this->_request->isPost()) {
				$data = $this->_request->getPost();
				if($form->isValid($data) && !empty($data['password'])) {
					$data  = $form->getValues();
					$table = new Identity();
					$where = $table->getAdapter()->quoteInto('id = ?', $this->view->info->id);
					$table->update(array('password' => $data['password']), $where);
				}
				$this->_redirect('/');
			}
			
			$info = (array) $this->view->info;
			$role = (array) $this->view->info->role;
			$data = array(
				'username' => $info['username'],
				'role'     => $role['name']
			);
			$form->populate($data);
			$this->view->form = $form;
		}
	}
