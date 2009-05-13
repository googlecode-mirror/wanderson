<?php
	class Com_ClienteController extends System_Controller_Action {
		public function indexAction() {
			$form = new System_Form_FastCliente();
			$form->nome->setAttrib('onkeyup', 'javascript:search();');
			$form->email->setAttrib('onkeyup', 'javascript:search();');
			$form->telefone->setAttrib('onkeyup', 'javascript:search();');
			$this->view->form = $form;
		}
		public function fastAction() {
			$this->view->layout()->disableLayout();
			$form = new System_Form_FastCliente();
			$data = $this->getRequest()->getPost();
			$data = $form->populate($data)->getValues();
			
			$select = new System_Db_Select_FastCliente();
			$select
				->where('nome ILIKE ?', "%{$data['nome']}%")
				->where('email ILIKE ?', "%{$data['email']}%")
				->where('telefone ILIKE ?', "%{$data['telefone']}%");
			$rowset = $select->query()->fetchAll();
			$result = array();
			
			foreach($rowset as $row)
				$result[] = $row['id'];
			
			$table = new Com_Cliente();
			$clientes = $table->find($result);
			
			$view = new System_View_FastCliente();
			$view->clientes = $clientes;
			$consulta = $view->render('consulta.phtml');
			
			$this->view->consulta = $consulta;
		}
	}
