<?php
	class Admin_RoleController extends System_Controller_Action {
		public function init() {
			parent::init();
			$toolbar = new System_Toolbar_Role();
			$this->view->toolbar = $toolbar;
		}
		public function indexAction() {
			$options = array('rowClass' => 'Row_Role');
			$table   = new Role($options);
			$view = new System_View();
			
			$view->roles = $table->fetchAll(null, array('level ASC', 'name ASC'));
			$this->view->tabela = $view->render('tabela.phtml');
		}
		public function saveAction() {
			$this->getRequest()->setActionName('index');
			$root = Zend_Registry::get('root');
			$file = $root.'/application/config/joana.acl';
			System_Acl::setFile($file);
			$acl  = System_Acl::loadFromDb();
			$this->view->saved = "<p class=\"note\">Dados salvos com sucesso!</p>";
			$this->indexAction();
		}
		public function editAction() {
			$form = new System_Form_Role();
			
			if($this->_request->isPost()) {
				$data = $this->_request->getPost();
				if($form->isValid($data)) {
					$data = $form->getValues();
					unset($data['submit']);
					
					$resources = $data['resources'];
					unset($data['resources']);
					
					$table = new Role();
					$record = $table->find($data['id'])->current();
					if(is_null($record)) {
						unset($data['id']);
						$record = $table->createRow($data);
					}
					else
						$record->setFromArray($data);
					$father = $record->findParentRow('Role');
					if(!is_null($father)) {
						if($father->name == $record->name)
							$record->level = $father->level;
						else
							$record->level = $father->level + 1;
					}
					
					try {
						$record->save();
						
						/* Permissions */
						$table = new Permission();
						$where = $table->getAdapter()->quoteInto('fkrole = ?', $record->id);
						$table->delete($where);
						foreach($resources as $resource)
							$table->insert(array('fkrole' => $record->id, 'fkresource' => $resource));
						
						$this->_redirect('/admin/role');
					}
					catch(Zend_Db_Statement_Exception $e) {
						if(substr_count($e->getMessage(), 'role_value_key'))
							$form->value->addError(System_Validate::IS_UNIQUE);
						else
							throw $e;
					}
				}
			}
			else {
				$filter = new System_Filter_PrimaryKey();
				$value  = $this->_request->getParam('id');
				$value  = $filter->filter($value);
				$table  = new Role();
				$record = $table->find($value)->current();
				if(!is_null($record)) {
					$form->populate($record->toArray());
					/* Permissions */
					$permissions = $record->findDependentRowset('Permission');
					$resources = array();
					foreach($permissions as $permission)
						$resources[] = $permission->fkresource;
					$form->resources->setValue($resources);
					
					$father    = $record->findParentRow('Role');
					$inherits  = array();
					$table     = new Resource();
					$resources = $table->fetchAll();
					$acl       = System_Acl::loadFromDb();
					foreach($resources as $resource)
						if($acl->isAllowed($father->value, $resource->value))
							$inherits[] = $resource->name;
					$this->view->inherits = $inherits;
				}
			}
			
			$this->view->form = $form;
		}
		public function deleteAction() {
			$form   = new System_Form_Role();
			$filter = new System_Filter_PrimaryKey();
			$table  = new Role();
			
			foreach($form as $element)
				$element->setAttrib('disabled', 'disabled');
			$form->id->setAttrib('disabled', null);
			$form->submit->setAttrib('disabled', null)->setLabel('Deletar');
			
			if($this->getRequest()->isPost())
				$id = $this->getRequest()->getPost('id');
			else
				$id = $this->getRequest()->getParam('id');
			$id = $filter->filter($id);
			
			$record = $table->find($id)->current();
			
			if(is_null($record))
				$this->_redirect('/admin/role');
			
			if($this->getRequest()->isPost()) {
				$record->delete();
				$this->_redirect('/admin/role');
			}
			else {
				$perm   = array();
				$rowset = $record->findDependentRowset('Permission');
				foreach($rowset as $row)
					$perm[] = $row->fkresource;
				$form->populate($record->toArray());
				$form->resources->setValue($perm);
			}
				
//				Zend_Debug::dump($record->toArray());exit();
			
			$this->view->form = $form;
		}
	}
