<?php
	class Admin_ResourceController extends System_Controller_Action {
		public function indexAction() {
			$table     = new Resource();
			$resources = $table->fetchAll(null, 'name ASC');
			$this->view->resources = $resources;
		}
		public function editAction() {
			$form = new System_Form_Resource();
			
			if($this->_request->isPost()) {
				$data = $this->_request->getPost();
				if($form->isValid($data)) {
					$data = $form->getValues();
					unset($data['submit']);
					
					$table = new Resource();
					$record = $table->find($data['id'])->current();
					if(is_null($record)) {
						unset($data['id']);
						$record = $table->createRow($data);
					}
					else
						$record->setFromArray($data);
					try {
						$record->save();
						$this->_redirect('/admin/resource');
					}
					catch(Zend_Db_Statement_Exception $e) {
						if(substr_count($e->getMessage(), 'resource_value_key'))
							$form->addError('O Identificador já existe no Banco de Dados.');
						else
							throw $e;
					}
				}
			}
			else {
				$filter = new System_Filter_PrimaryKey();
				$value  = $this->_request->getParam('id');
				$value  = $filter->filter($value);
				$table  = new Resource();
				$record = $table->find($value)->current();
				if(!is_null($record))
					$form->populate($record->toArray());
			}
			
			$this->view->form = $form;
		}
		public function deleteAction() {}
	}
