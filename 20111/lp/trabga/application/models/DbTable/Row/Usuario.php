<?php

/**
 * Usuario Table Row
 * 
 * @category   Application
 * @package    Appliation_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Row_Usuario extends Local_Db_Table_Row
{
    protected function _update()
    {
        // Alterações no Root
        if ($this->_cleanData['identidade'] == 'root') {
            // Alteração de Nome ou Identificador
            $result = 'root' != $this->identidade
                || $this->_cleanData['idusuario'] != $this->idusuario;
            if ($result) { // Alteração Feita sobre Campos Impróprios
                throw new Zend_Db_Exception('Forbidden');
            }
        }
    }
}