<?php

/**
 * Artigo
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Usuario extends Local_Db_TableAbstract
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

    protected $_dependentTables = array(
        'Artigo'     => 'Application_Model_DbTable_Artigo',
        'Figura'     => 'Application_Model_DbTable_Figura',
        'Referencia' => 'Application_Model_DbTable_Referencia',
    );

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Autor' => array(
            'columns' => array('idusuario'),
            'refColumns' => array('idautor'),
            'refTableClass' => 'Application_Model_DbTable_Autor',
        ),
    );
}
