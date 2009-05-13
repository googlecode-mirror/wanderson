<?php
	class Com_Cliente extends Zend_Db_Table_Abstract {
		protected $_primary         = 'id';
		protected $_name            = 'com_cliente';
		protected $_dependentTables = array(
			'Com_Telefone',
			'Com_Email',
			'Com_Observacao'
		);
		protected $_referenceMap    = array(
			'Identity' => array(
				'columns'       => 'fkatendente',
				'refTableClass' => 'Identity',
				'refColumn'     => 'id'
			)
		);
	}
