<?php
	class CursoModulo extends Zend_Db_Table_Abstract {
		protected $_name = 'curso_modulo';
		protected $_primary = 'id';
		protected $_dependentTables = array();
		protected $_referenceMap = array(
			'Curso' => array(
				'columns'       => 'fkcurso',
				'refTableClass' => 'Curso',
				'refColumn'     => 'id'
			),
			'Modulo' => array(
				'columns'       => 'fkmodulo',
				'refTableClass' => 'Modulo',
				'refColumn'     => 'id'
			),
		);
	}
