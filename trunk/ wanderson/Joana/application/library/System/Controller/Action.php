<?php
	/**
	 * Joana Aplicativo Interno de Administração
	 * @category System
	 * @package System_Controller
	 */
	
	/**
	 * Classe extendida do Zend Framework para pré-configuração.
	 * @category System
	 * @package  System_Control
	 * @extends  Zend_Controller_Action
	 */
	abstract class System_Controller_Action extends Zend_Controller_Action {
		/**
		 * Inicialização do Objeto
		 * @return System_Controller_Action
		 */
		public function init() {
			/* Inicialização de Variáveis */
			$module     = $this->_request->getModuleName();
			$controller = $this->_request->getControllerName();
			$action     = $this->_request->getActionName();
			/* Zend Config */
			$config = Zend_Registry::get('config');
			/* Zend Auth */
			$auth = Zend_Auth::getInstance();
			if(!$auth->hasIdentity() && $module != 'auth' && $config->auth->check)
				$this->_redirect('/auth/login');
			if($config->auth->blocked && $action != 'blocked')
				$this->_redirect('/auth/login/blocked');
			/* Zend Acl */
			$file = Zend_Registry::get('root').'/application/config/joana.acl';
			$acl  = Zend_Registry::get('acl');
			$info = $auth->getStorage()->read();
			if($config->auth->check && $module != 'auth')
				if(!$acl->isAllowed($info->role->value, $module))
					throw new System_Exception('Unauthorized Access');
			/* Zend Layout */
			$this->view->layout()->setLayout($config->layout->name);
			$this->view->doctype('XHTML1_STRICT');
			$this->view->headTitle()->setSeparator(' | ');
			$this->view->headTitle('Joana | Instituto de Informática');
			if(!$config->layout->render)
				$this->view->layout()->disableLayout();
			/* Barra Header */
			$img = '/img/barra-'.$module.'.jpg';
			if(is_file(Zend_Registry::get('root').$img))
				$barra = '<h1><img src="'.$this->_request->getBaseUrl().$img.'" /></h1>';
			/* Inicializando Variáveis na Zend View */
			$this->view->menu    = new System_Toolbar_Menu();
			$this->view->baseUrl = $this->_request->getBaseurl();
			$this->view->info    = $info;
			$this->view->barra   = $barra;
		}
	}
