<?php

/**
 * Linha de Tabela
 * 
 * Sobrescrita de métodos para facilitar a busca de elementos tendo em vista que
 * as chaves dos mapeamentos são diferentes. Trabalha sobre estas chaves que
 * podem ser recebidas como parâmetros únicos, facilitando a programação.
 * 
 * @category   Local
 * @package    Local_Db
 * @subpackage Table
 */
class Local_Db_Table_Row extends Zend_Db_Table_Row_Abstract
{
    public function findParentRow($parentTable, $ruleKey = null, Zend_Db_Table_Select $select = null)
    {
        // Possível Informação de Chave
        if (is_string($parentTable)) {
            $needle = $parentTable;
            $mapper = $this->getTable()->info(Zend_Db_Table::REFERENCE_MAP);
            // Busca por Chave como Referência
            if (array_key_exists($needle, $mapper)) {
                // Chave Encontrada
                // Transformando a Pesquisa
                $ruleKey     = $parentTable; // Tabela Informada = Chave de Busca
                $parentTable = $mapper[$ruleKey]['refTableClass']; // Informações na Tabela
            }
        }
        return parent::findParentRow($parentTable, $ruleKey, $select);
    }

    public function findDependentRowset($dependentTable, $ruleKey = null, Zend_Db_Table_Select $select = null)
    {
        // Possível Informação de Chave
        if (is_string($dependentTable)) {
            $needle = $dependentTable;
            $mapper = $this->getTable()->info(Zend_Db_Table::DEPENDENT_TABLES);
            // Busca por Chave como Referência
            if (array_key_exists($needle, $mapper)) {
                // Chave Encontrada
                // Transformando a Pesquisa
                $dependentTable = $mapper[$needle]; // Tabela Informada = Tabela Dependente
            }
        }
        return parent::findDependentRowset($dependentTable, $ruleKey, $select);
    }
}