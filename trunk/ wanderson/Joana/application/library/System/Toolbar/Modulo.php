<?php
	class System_Toolbar_Modulo extends System_Toolbar_List {
		public function __construct() {
			parent::__construct();
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			
			$buttons = array();
			$buttons[] = new System_Toolbar_Button_Image('novo', 'Novo Módulo', 'add.png', '/prod/modulo/edit');
			$buttons[] = new System_Toolbar_Button_Image('listar', 'Todos os Módulos', 'object_10.png', '/prod/modulo/');
			$buttons[] = new System_Toolbar_Button_Image('producao', 'Módulos em Produção', 'tool.png', '/prod/modulo/producao');
			$buttons[] = new System_Toolbar_Button_Image('venda', 'Módulos Abertos para Venda', 'money.png', '/prod/modulo/venda');
			
			foreach($buttons as $button) :
				$button->setSrc($baseUrl.'/img/tool/blue/'.$button->getSrc());
				$button->setHref($baseUrl.$button->getHref());
			endforeach;
			
			$this
			->setButtons($buttons)
			->setAttrib('class', 'toolbar');
		}
	}
