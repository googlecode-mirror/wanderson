<?php
/**
 * Pokeflute Library
 * @author Wanderson Henrique Camargo Rosa
 */
namespace Pokeflute;

/**
 * Pokeflute Database Adapter
 *
 * @category Pokeflute
 * @package  Pokeflute_Db
 */
class DbAdapter {

    /**
     * Singleton Instance
     * @var DbAdapter
     */
    private static $_instance = null;

    /**
     * Database SQLite3 Resource
     * @var \SQLite3
     */
    protected $_resource = null;

    /**
     * Singleton Access
     * @return DbAdapter Singleton Instance
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Singleton Constructor
     */
    private function __construct() {
        // Nome do Arquivo para Abertura
        $filename = APPLICATION_PATH . '/../data/pokeflute.sqlite';
        // Criação de Recurso para Conexão
        $this->_resource = new \SQLite3($filename);
    }

    /**
     * Acesso ao Banco de Dados
     * @return \SQLite3 Elemento Solicitado
     */
    public function getResource() {
        return $this->_resource;
    }

}

