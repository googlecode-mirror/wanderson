<?php
	class Prod_ModuloController extends System_Controller_Action {
		public function init() {
			parent::init();
			$toolbar = new System_Toolbar_Modulo();
			$this->view->toolbar = $toolbar;
		}
		public function indexAction() {
			$view    = new System_View();
			$table   = new Modulo();
			
			$order   = $this->getRequest()->getParam('order');
			try {
				$modulos = $table->fetchAll(null, $order.' ASC');
			}
			catch(Zend_Db_Statement_Exception $e) {
				$modulos = $table->fetchAll();
			}
			$view->assign('modulos', $modulos);
			
			$this->view->top     = 'Todos os Módulos';
			$this->view->tabela  = $view->render('tabela.phtml');
		}
		public function producaoAction() {
			$this->getRequest()->setActionName('index');
			
			$view    = new System_View();
			$table   = new Modulo();
			
			$where   = $table->getAdapter()->quoteInto('producao = ?', 'true');
			$order   = $this->getRequest()->getParam('order');
			$order   = empty($order) ? null : $order.' ASC';
			try {
				$modulos = $table->fetchAll($where, $order);
			}
			catch(Zend_Db_Statement_Exception $e) {
				$modulos = $table->fetchAll();
			}
			$view->assign('modulos', $modulos);
			
			$this->view->top     = 'Módulos em Produção';
			$this->view->tabela  = $view->render('tabela.phtml');
		}
		public function vendaAction() {
			$this->getRequest()->setActionName('index');
			
			$view    = new System_View();
			$table   = new Modulo();
			
			$where   = $table->getAdapter()->quoteInto('venda = ?', 'true');
			$order   = $this->getRequest()->getParam('order');
			$order   = empty($order) ? null : $order.' ASC';
			try {
				
				$modulos = $table->fetchAll($where, $order);
			}
			catch(Zend_Db_Statement_Exception $e) {
				throw $e;
			}
			$view->assign('modulos', $modulos);
			
			$this->view->top     = 'Módulos Abertos para Venda';
			$this->view->tabela  = $view->render('tabela.phtml');
		}
		public function editAction() {
			$form = new System_Form_Modulo();
			
			if($this->getRequest()->isPost()) {
				$data = $this->getRequest()->getPost();
				if($form->isValid($data)) {
					$data   = $form->getValues();
					unset($data['submit']);
					$table  = new Modulo();
					$record = $table->find($data['id'])->current();
					if(is_null($record)) {
						unset($data['id']);
						$record = $table->createRow($data);
					}
					else
						$record->setFromArray($data);
					try {
						if($form->minimo->getValue() > $form->maximo->getValue())
							throw new System_Validate_Exception();
						$record->save();
						$this->_redirect('/prod/modulo');
					}
					catch(Zend_Db_Statement_Exception $e) {
						$haystack = $e->getMessage();
						if(stripos($haystack, 'modulo_codigo_key') !== false)
							$form->codigo->addError(System_Validate::IS_UNIQUE);
						elseif(stripos($haystack, 'modulo_nome_key') !== false)
							$form->nome->addError(System_Validate::IS_UNIQUE);
						else
							throw $e;
					}
					catch(System_Validate_Exception $e) {
						$form->minimo->addError(System_Validate::MIN);
					}
				}
			}
			else {
				$filter = new System_Filter_PrimaryKey();
				$id     = $this->getRequest()->getParam('id');
				$clone  = $this->getRequest()->getParam('clone');
				if(!is_null($clone))
					$id = $clone;
				$id     = $filter->filter($id);
				$table  = new Modulo();
				$record = $table->find($id)->current();
				if(!is_null($record)) {
					$form->populate($record->toArray());
					if(!is_null($clone)) {
						$form->id->setValue(0);
					}
					else {
						$button = new System_Toolbar_Button_Image('bclone','Clonar','/img/tool/yellow/ok.png');
						$button->setSrc($this->view->baseUrl.$button->getSrc());
						$button->setHref($this->view->baseUrl.'/prod/modulo/edit/clone/'.$id);
						$this->view->toolbar->addButton($button);
					}
				}
			}
			
			$this->view->form = $form;
		}
		public function deleteAction() {
			$filter = new System_Filter_PrimaryKey();
			$table  = new Modulo();
			$form   = new System_Form_Modulo();
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
				$this->_redirect('/prod/modulo');
			if($this->getRequest()->isPost()) {
				$rowset  = $record->findDependentRowset('CursoModulo');
				foreach($rowset as $row)
					$row->delete();
				$record->delete();
				$this->_redirect('/prod/modulo');
			}
			else
				$form->populate($record->toArray());
			
			$this->view->form = $form;
		}
	}
