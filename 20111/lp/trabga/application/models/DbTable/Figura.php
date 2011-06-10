<?php

/**
 * Figura
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Figura extends Zend_Db_Table_Abstract
{
    /**
     * Esquema
     * @var string
     */
    protected $_schema = 'sistema';

    /**
     * Nome da Tablea
     * @var string
     */
    protected $_name = 'figura';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('figura');

    /**
     * Tabelas Dependentes
     * @var array
     */
    protected $_dependentTables = array(
        'RArtigoFigura' => 'Application_Model_DbTable_RArtigoFigura',
    );
}
