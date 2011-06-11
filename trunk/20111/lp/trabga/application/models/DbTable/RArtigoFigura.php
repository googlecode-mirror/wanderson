<?php

/**
 * Relacionamento Artigo Figura
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_RArtigoFigura extends Zend_Db_Table_Abstract
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
    protected $_name = 'r_artigo_figura';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idartigo','idfigura');

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Artigo' => array(
            'columns' => array('idartigo'),
            'refColumns' => array('idartigo'),
            'refTableClass' => 'Application_Model_DbTable_Artigo',
        ),
        'Figura' => array(
            'columns' => array('idfigura'),
            'refColumns' => array('idfigura'),
            'refTableClass' => 'Application_Model_DbTable_Autor',
        ),
    );
}
