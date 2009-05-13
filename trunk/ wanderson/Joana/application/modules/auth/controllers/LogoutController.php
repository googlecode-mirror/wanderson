<?php
	class Auth_LogoutController extends System_Controller_Action {
		public function indexAction() {
			$auth = Zend_Auth::getInstance();
			$auth->clearIdentity();
			$this->_redirect('/auth/login');
		}
	}
