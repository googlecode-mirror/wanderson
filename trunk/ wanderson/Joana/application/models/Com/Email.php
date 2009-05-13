<?php
	class Com_Email extends Zend_Db_Table_Abstract {
		protected $_name            = 'com_email';
		protected $_primary         = 'id';
		protected $_dependentTables = array();
		protected $_referenceMap    = array(
			'Com_Cliente' => array(
				'columns'       => 'fkcliente',
				'refTableClass' => 'Com_Cliente',
				'refColumns'    => 'id'
			)
		);
	}