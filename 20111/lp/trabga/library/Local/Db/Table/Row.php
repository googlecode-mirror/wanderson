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
        if (is_string($parentTable) && !isset($ruleKey)) {
            $needle = $parentTable;
            $mapper = $this->getTable()->info(Zend_Db_Table::REFERENCE_MAP);
            // Busca por Chave como Referência
            if (array_key_exists($needle, $mapper)) {
                // Chave Encontrada
                // Transformando a Pesquisa
                $parentTable = $mapper[$needle]['refTableClass']; // Informações na Tabela
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

    public function findManyToManyRowset($matchTable, $intersectionTable, $callerRefRule = null, $matchRefRule = null, Zend_Db_Table_Select $select = null)
    {
        // Possível Informação de Chaves
        if (is_string($intersectionTable) && is_string($matchTable) && !isset($callerRefRule, $matchRefRule)) {
            $needle1 = $intersectionTable;
            $mapper1 = $this->getTable()->info(Zend_Db_Table::DEPENDENT_TABLES);
            // Busca por Chave como Referência
            if (array_key_exists($needle1, $mapper1)) {
                // Chave Encontrada
                // Construindo Tabela Intermediária
                $intersection = $this->_getTableFromString($mapper1[$needle1]);
                $needle2 = $matchTable;
                $mapper2 = $intersection->info(Zend_Db_Table::REFERENCE_MAP);
                // Busca por Chave como Referência
                if (array_key_exists($needle2, $mapper2)) {
                    // Chave Encontrada
                    // Transformando a Pesquisa
                    $intersectionTable = $mapper1[$needle1]; // Tabela Real = Mapeamento
                    $matchTable = $mapper2[$needle2]['refTableClass']; // Intersecção Real = Mapeamento
                }
            }
        }
        return parent::findManyToManyRowset($matchTable, $intersectionTable, $callerRefRule, $matchRefRule, $select);
    }
}