<?php
	class Com_Observacao extends Zend_Db_Table_Abstract {
		protected $_name            = 'com_observacao';
		protected $_primary         = 'id';
		protected $_dependentTables = array();
		protected $_referenceMap    = array(
			'Com_Cliente' => array(
				'columns'       => 'fkcliente',
				'refTableClass' => 'Com_Cliente',
				'refColumns'    => 'id'
			),
			'Identity'    => array(
				'columns'       => 'fkatendente',
				'refTableClass' => 'Identity',
				'refColumns'    => 'id'
			)
		);
	}