<?php

/**
 * Autor
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Autor extends Zend_Db_Table_Abstract
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
    protected $_name = 'autor';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idautor');

    /**
     * Tabelas Dependentes
     * @var array
     */
    protected $_dependentTables = array(
        'RArtigoAutor' => 'Application_Model_DbTable_RArtigoAutor',
    );

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Instituicao' => array(
            'columns' => array('idinstituicao'),
            'refColumns' => array('idinstituicao'),
            'refTableClass' => 'Application_Model_DbTable_Instituicao',
        ),
    );
}

