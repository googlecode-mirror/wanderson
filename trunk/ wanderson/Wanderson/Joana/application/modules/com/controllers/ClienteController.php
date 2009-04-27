<?php
	class Com_ClienteController extends System_Controller_Action {
		public function indexAction() {
			$form = new System_Form_FastCliente();
			$form->nome->setAttrib('onkeyup', 'javascript:search();');
			$form->email->setAttrib('onkeyup', 'javascript:search();');
			$this->view->form = $form;
		}
		public function fastAction() {
			$this->view->layout()->disableLayout();
			$select = new System_Db_Select_FastCliente();
			$f      = new Zend_Filter();
			$f
				->addFilter(new Zend_Filter_StripTags())
				->addFilter(new Zend_Filter_StringTrim());
			
			$nome   = $f->filter($this->getRequest()->getParam('nome'));
			$nome   = $select->getAdapter()->quoteInto('nome ILIKE ?', '%'.$nome.'%');
			
			$email  = $f->filter($this->getRequest()->getParam('email'));
			$email  = $select->getAdapter()->quoteInto('email ILIKE ?', '%'.$email.'%');
			
			$fone   = $f->filter($this->getRequest()->getParam('telefone'));
			$fone   = $select->getAdapter()->quoteInto('telefone ILIKE ?', '%'.$fone.'%');
			
			$select->where($nome)->where($email)->where($fone);
//				->orWhere('email IS NULL')->orWhere('telefone IS NULL');
			
			$result = $select->getAdapter()->query($select)->fetchAll();
			
			$identity = new Zend_Db_Select($select->getAdapter());
			foreach($result as $row)
				$identity->orWhere('id = '.$row['id']);
			
			$table  = new Com_Cliente();
			$view   = new System_View();
			$result = $table->fetchAll($where);
			$view->clientes = $result;
			
			$this->view->consulta = $view->render('consulta.phtml');
		}
	}
