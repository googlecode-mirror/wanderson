<?php

/**
 * Figura
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Figura extends Local_Db_TableAbstract
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
    protected $_primaries = array('idfigura');

    /**
     * Linha Padrão da Tabela
     * @var string
     */
    protected $_rowClass = 'Application_Model_DbTable_Row_Figura';

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Usuario' => array(
            'columns' => array('idusuario'),
            'refColumns' => array('idusuario'),
            'refTableClass' => 'Application_Model_DbTable_Usuario',
        ),
    );
}
