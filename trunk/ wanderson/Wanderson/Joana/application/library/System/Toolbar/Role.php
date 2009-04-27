<?php
	class System_Toolbar_Role extends System_Toolbar_List {
		public function __construct() {
			parent::__construct();
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			
			$buttons   = array();
			$buttons[] = new System_Toolbar_Button_Image('novo', 'Novo Grupo', 'add.png', 'edit');
			$buttons[] = new System_Toolbar_Button_Image('todos', 'Todos os Grupos', 'group.png', '');
			$buttons[] = new System_Toolbar_Button_Image('salvar', 'Salvar Alterações', 'ok.png', 'save');
			
			foreach($buttons as $button) {
				$button->setSrc($baseUrl.'/img/tool/blue/'.$button->getSrc());
				$button->setHref($baseUrl.'/admin/role/'.$button->getHref());
			}
			
			$this->setButtons($buttons)->setAttrib('class', 'toolbar');
		}
	}
