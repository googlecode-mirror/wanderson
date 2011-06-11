<?php

/**
 * Referência Table Row
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Row_Referencia extends Local_Db_Table_Row
{
    protected function _insert()
    {
        // Identificador do Usuário Atual
        $this->idusuario = 1; // @todo Fornecer o Identificador do Usuário
    }
}