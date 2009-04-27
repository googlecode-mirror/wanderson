<?php
	class Prod_CursoController extends System_Controller_Action {
		public function init() {
			parent::init();
			$toolbar = new System_Toolbar_Curso();
			$this->view->toolbar = $toolbar;
		}
		public function indexAction() {
			$view  = new System_View();
			$table = new Curso();
			
			$order = $this->getRequest()->getParam('order');
			try {
				$cursos = $table->fetchAll(null, $order.' ASC');
			}
			catch(Zend_Db_Statement_Exception $e) {
				$cursos = $table->fetchAll();
			}
			$view->assign('cursos', $cursos);
			
			$this->view->top    = 'Todos os Cursos';
			$this->view->tabela = $view->render('tabela.phtml');
		}
		public function producaoAction() {
			$this->getRequest()->setActionName('index');
			$view  = new System_View();
			$table = new Curso();
			
			$order = $this->getRequest()->getParam('order');
			$order = empty($order) ? null : $order.' ASC';
			$where = $table->getAdapter()->quoteInto('producao = ?', 'true');
			try {
				$cursos = $table->fetchAll($where, $order);
			}
			catch(Zend_Db_Statement_Exception $e) {
				$cursos = $table->fetchAll();
			}
			$view->assign('cursos', $cursos);
			
			$this->view->top    = 'Cursos em Produção';
			$this->view->tabela = $view->render('tabela.phtml');
		}
		public function vendaAction() {
			$this->getRequest()->setActionName('index');
			$view  = new System_View();
			$table = new Curso();
			
			$order = $this->getRequest()->getParam('order');
			$order = empty($order) ? null : $order.' ASC';
			$where = $table->getAdapter()->quoteInto('venda = ?', 'true');
			try {
				$cursos = $table->fetchAll($where, $order);
			}
			catch(Zend_Db_Statement_Exception $e) {
				$cursos = $table->fetchAll();
			}
			$view->assign('cursos', $cursos);
			
			$this->view->top    = 'Cursos Abertos para Venda';
			$this->view->tabela = $view->render('tabela.phtml');
		}
		public function editAction() {
			$form = new System_Form_Curso();
			
			if($this->getRequest()->isPost()) {
				$data = $this->getRequest()->getPost();
				if($form->isValid($data)) {
					$data    = $form->getValues();
					unset($data['submit']);
					$modulos = $data['fkmodulo'];
					unset($data['fkmodulo']);
					$table   = new Curso();
					$record  = $table->find($data['id'])->current();
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
						
						$where = $table->getAdapter()->quoteInto('fkcurso = ?', $record->id);
						$table = new CursoModulo();
						$table->delete($where);
						foreach($modulos as $modulo)
							$table->insert(array('fkcurso' => $record->id, 'fkmodulo' => $modulo));
						
						$this->_redirect('/prod/curso');
					}
					catch(Zend_Db_Statement_Exception $e) {
						$haystack = $e->getMessage();
						if(stripos($haystack, 'curso_codigo_key') !== false)
							$form->codigo->addError(System_Validate::IS_UNIQUE);
						elseif(stripos($haystack, 'curso_nome_key') !== false)
							$form->nome->addError(System_Validate::IS_UNIQUE);
						else
							throw $e;
					}
					catch(System_Validate_Exception $e) {
						$form->minimo->addError(System_Validate::MIN);
					};
				}
			}
			else {
				$filter = new System_Filter_PrimaryKey();
				$table  = new Curso();
				$id     = $this->getRequest()->getParam('id');
				$clone  = $this->getRequest()->getParam('clone');
				if(!is_null($clone))
					$id = $clone;
				$id     = $filter->filter($id);
				$curso  = $table->find($id)->current();
				if(!is_null($curso)) {
					$form->populate($curso->toArray());
					$rowset = $curso->findDependentRowset('CursoModulo');
					$modulos = array();
					foreach($rowset as $row)
						$modulos[] = $row->fkmodulo;
					$form->fkmodulo->setValue($modulos);
					if(!is_null($clone)) {
						$form->id->setValue(0);
					}
					else {
						$button = new System_Toolbar_Button_Image('bclone','Clonar','/img/tool/yellow/ok.png');
						$button->setSrc($this->view->baseUrl.$button->getSrc());
						$button->setHref($this->view->baseUrl.'/prod/curso/edit/clone/'.$id);
						$this->view->toolbar->addButton($button);
					}
				}
			}
			
			$this->view->form = $form;
		}
		public function deleteAction() {
			$form   = new System_Form_Curso();
			$table  = new Curso();
			$filter = new System_Filter_PrimaryKey();
			
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
				$this->_redirect('/prod/curso');
			
			if($this->getRequest()->isPost()) {
				$rowset  = $record->findDependentRowset('CursoModulo');
				foreach($rowset as $row)
					$row->delete();
				$record->delete();
				$this->_redirect('/prod/curso');
			}
			else {
				$modulos = array();
				$rowset  = $record->findDependentRowset('CursoModulo');
				foreach($rowset as $row)
					$modulos[] = $row->fkmodulo;
				$form->populate($record->toArray());
				$form->fkmodulo->setValue($modulos);
			}
			
			$this->view->form = $form;
		}
	}
