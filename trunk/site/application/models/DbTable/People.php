<?php

/**
 * Tabela de Pessoas
 * Gerenciamento de Usuários do Sistema
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Model
 * @see        http://code.google.com/p/wanderson/
 */
class Application_Model_DbTable_People extends Zend_Db_Table_Abstract
{
    /**
     * Esquema da Tabela
     * @var string
     */
    protected $_schema = 'site';

    /**
     * Nome da Tabela
     * @var string
     */
    protected $_name = 'people';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primary = array('id');
}
