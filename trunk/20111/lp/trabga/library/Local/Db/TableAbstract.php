<?php

/**
 * Abstração de Tabelas em Banco de Dados
 * 
 * @category   Local
 * @package    Local_Db
 * @subpackage Table
 */
class Local_Db_TableAbstract extends Zend_Db_Table_Abstract
{
    /**
     * Informa o Nome Completo da Tabela no Banco de Dados
     * @return string Valor Solicitado
     */
    public function getTableName()
    {
        $name   = $this->info(self::NAME);
        $schema = $this->info(self::SCHEMA);
        return $schema == null ? $name : "$schema.$name";
    }
}