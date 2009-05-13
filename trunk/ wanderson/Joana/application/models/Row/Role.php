<?php
	class Row_Role extends Zend_Db_Table_Row_Abstract {
		public function init() {
			$this->_data['parent'] = null;
			if(!is_null($this->father)) {
				$this->parent = $this->findParentRow('Role');
			}
		}
	}
