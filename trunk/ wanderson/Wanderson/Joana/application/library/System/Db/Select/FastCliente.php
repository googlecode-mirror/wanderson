<?php
	class System_Db_Select_FastCliente extends Zend_Db_Select {
		public function __construct() {
			$adapter = Zend_Db_Table::getDefaultAdapter();
			parent::__construct($adapter);
			$where   = array();
			$where[] = 'id = 1';
			$this
				->from(array('cliente' => 'com_cliente'),array('cliente.id'))
				->joinLeft(array('email' => 'com_email'), 'cliente.id = email.fkcliente', array())
				->joinLeft(array('telefone' => 'com_telefone'), 'cliente.id = telefone.fkcliente', array())
				->distinct()
				->limit(10);
		}
	}
