<?php
	class System_Toolbar_Menu extends System_Toolbar_List {
		public function __construct() {
			parent::__construct();
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			$role    = Zend_Auth::getInstance()->getStorage()->read()->role->value;
			$auth    = System_Acl::getInstance();
			$config  = Zend_Registry::get('config');
			
			$buttons   = array();
			$buttons[] = new System_Toolbar_Button_Href('menu-inicio', 'Início', $baseUrl.'/');
			$buttons[] = new System_Toolbar_Button_Href('menu-perfil', 'Perfil', $baseUrl.'/profile');
			$buttons[] = new System_Toolbar_Button_Href('menu-sair',   'Sair',   $baseUrl.'/auth/logout');
			
			$menu      = new System_Toolbar_Button_Text('Sistema');
			$menu->setToolbar(new System_Toolbar_List($buttons));
			$this->addButton($menu);
			
			try {
			
			if($auth->isAllowed($role, 'admin')) :
			
			$buttons   = array();
			$buttons[] = new System_Toolbar_Button_Href('menu-user',     'Usuários', $baseUrl.'/admin/user');
			$buttons[] = new System_Toolbar_Button_Href('menu-role',     'Grupos',   $baseUrl.'/admin/role');
			$buttons[] = new System_Toolbar_Button_Href('menu-resource', 'Módulos',  $baseUrl.'/admin/resource');
			
			$menu      = new System_Toolbar_Button_Text('Administração');
			$menu->setToolbar(new System_Toolbar_List($buttons));
			$this->addButton($menu);
			
			endif;
			
			if($auth->isAllowed($role, 'prod')) :
			
			$buttons   = array();
			$buttons[] = new System_Toolbar_Button_Href('menu-curso', 'Cursos',   $baseUrl.'/prod/curso');
			$buttons[] = new System_Toolbar_Button_Href('menu-modulo', 'Módulos', $baseUrl.'/prod/modulo');
			
			$menu      = new System_Toolbar_Button_Text('Produtos');
			$menu->setToolbar(new System_Toolbar_List($buttons));
			$this->addButton($menu);
			
			endif;
			
			}
			catch(Zend_Acl_Exception $e){}
		}
	}
