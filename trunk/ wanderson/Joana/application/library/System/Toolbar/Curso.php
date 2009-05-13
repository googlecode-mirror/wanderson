<?php
	class System_Toolbar_Curso extends System_Toolbar_List {
		public function __construct() {
			parent::__construct();
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			
			$buttons   = array();
			$buttons[] = new System_Toolbar_Button_Image('bnovo', 'Novo Curso', 'add.png', '/prod/curso/edit');
			$buttons[] = new System_Toolbar_Button_Image('blistar', 'Todos os Cursos', 'object_10.png', '/prod/curso/');
			$buttons[] = new System_Toolbar_Button_Image('bproducao', 'Cursos em Produção', 'tool.png', '/prod/curso/producao');
			$buttons[] = new System_Toolbar_Button_Image('bvenda', 'Cursos Abertos para Venda', 'money.png', '/prod/curso/venda');
			
			foreach($buttons as $button) :
				$button->setSrc($baseUrl.'/img/tool/blue/'.$button->getSrc());
				$button->setHref($baseUrl.$button->getHref());
			endforeach;
			
			$this
			->setButtons($buttons)
			->setAttrib('class', 'toolbar');
		}
	}
