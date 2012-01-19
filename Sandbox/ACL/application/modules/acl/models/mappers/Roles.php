<?php

/**
 * Mapeamento para Funções
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category   Acl
 * @package    Acl_Model
 * @subpackage Mapper
 */
class Acl_Model_Mapper_Roles
{
    /**
     * Consulta de Funções Cadastradas
     * @param  array $params Parâmetros de Seleção
     * @return array Conjunto de Informações Selecionadas
     */
    public function fetch(array $params = array())
    {
        // Tabela de Banco de Dados
        $table = new Acl_Model_DbTable_AclRoles();
        // Busca de Informações
        $select = $table->getAdapter()->select()
            ->from($table->info(Zend_Db_Table::NAME), Zend_Db_Select::SQL_WILDCARD, $table->info(Zend_Db_Table::SCHEMA));
        // Seleção de Elementos
        $result = $table->getAdapter()->fetchAll($select);
        // Apresentação de Resultados
        return $result;
    }
}
