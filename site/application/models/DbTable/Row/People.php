<?php

/**
 * Linha da Tabela de Pessoas
 * Sobrescrita do Método de Deleção de Usuário
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Model
 * @see        http://code.google.com/p/wanderson/
 */
class Application_Model_DbTable_Row_People extends Zend_Db_Table_Row_Abstract
{
    public function delete()
    {
        $this->deleted = true;
        return $this->save();
    }
}