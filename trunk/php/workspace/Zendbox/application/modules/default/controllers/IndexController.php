<?php
	class IndexController extends System_Controller_Action {
		public function indexAction() {
			$form = new System_Form_Login();
			$this->view->form = $form;
		}
	}
