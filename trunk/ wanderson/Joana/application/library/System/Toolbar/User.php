<?php
	class System_Toolbar_User extends System_Toolbar_List {
		public function __construct() {
			parent::__construct();
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			
			$buttons   = array();
			$buttons[] = new System_Toolbar_Button_Image('novo', 'Novo Usuário', 'add.png', 'edit');
			$buttons[] = new System_Toolbar_Button_Image('todos', 'Todos os Usuários', 'user.png', '');
			
			foreach($buttons as $button) {
				$button->setSrc($baseUrl.'/img/tool/blue/'.$button->getSrc());
				$button->setHref($baseUrl.'/admin/user/'.$button->getHref());
			}
			
			$this->setButtons($buttons)->setAttrib('class', 'toolbar');
		}
	}
