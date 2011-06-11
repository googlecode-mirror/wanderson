<?php

/**
 * Artigo
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
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
    protected $_name = 'usuario';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idusuario');

    /**
     * Tabelas Dependentes
     * @var array
     */
    protected $_dependentTables = array(
        'RAutorArtigo' => 'Application_Model_DbTable_RAutorArtigo',
    );

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Autor' => array(
            'columns' => array('idusuario'),
            'refColumns' => array('idusuario'),
            'refTableClass' => 'Application_Model_DbTable_Autor',
        ),
    );
}