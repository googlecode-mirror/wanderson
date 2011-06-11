<?php

/**
 * Instituicao
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Instituicao extends Local_Db_TableAbstract
{
    /**
     * Esquema
     * @var string
     */
    protected $_schema = 'sistema';

    /**
     * Nome da Tabela
     * @var string
     */
    protected $_name = 'instituicao';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idinstituicao');

    /**
     * Tabelas Dependentes
     * @var array
     */
    protected $_dependentTables = array(
        'Autor' => 'Application_Model_DbTable_Autor',
    );
}
