<?php
	class System_Auth extends Zend_Auth {
		
		private $_valid = false;
		
		public function __construct($username = null, $password = null) {
			
			if($username != null && $password != null) {
				$database = Zend_Db_Table::getDefaultAdapter();
				if($database === null)
					throw new System_Auth_Exception();
				
				$adapter = new Zend_Auth_Adapter_DbTable($database);
				$adapter
					->setTableName('identity')
					->setIdentityColumn('username')
					->setCredentialColumn('passwd')
					->setIdentity($username)
					->setCredential($password);
				
				$result = $this->authenticate($adapter);
				
				if($result->isValid()) {
					$info = $adapter->getResultRowObject(null, 'password');
					if($info->allowed) {
						$this->_valid = true;
						$this->getStorage()->write($info);
					}
				}
			}
			
		}
		
		public function isValid() {
			return $this->_valid;
		}
	}
