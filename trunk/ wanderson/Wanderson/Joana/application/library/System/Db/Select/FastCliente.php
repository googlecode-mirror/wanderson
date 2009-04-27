<?php
	class System_Db_Select_FastCliente extends Zend_Db_Select {
		public function __construct() {
			$adapter = Zend_Db_Table::getDefaultAdapter();
			parent::__construct($adapter);
			$this
				->distinct()
				->from(array('cliente' => 'com_cliente'), 'id')
				->joinLeft(array('telefone' => 'com_telefone'), 'cliente.id = telefone.fkcliente', array())
				->joinLeft(array('email' => 'com_email'), 'cliente.id = email.fkcliente', array())
				->limit(10);
		}
	}
