<?php

/**
 * Modelo para Criação de Migrations
 * Classe Abstrata para Modificações de Banco de Dados
 * @author     Wanderson Henrique Camargo Rosa
 * @package    System
 * @subpackage Db
 * @see        http://github.com/akrabat/Akrabat/
 * @see        http://code.google.com/p/wanderson
 */
abstract class System_Db_Schema_AbstractChange
{
    /**
     * Adaptador do Banco de Dados
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    /**
     * Construtor da Classe
     * @param Zend_Db_Adapter_Abstract $db Adaptador do Banco de Dados
     */
    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
    }

    /**
     * Efetua Leitura de Estrutura de Arquivo
     * @return string Estrutura Encontrada para Atualização
     */
    public function read($filename, $migration)
    {
        $filename = (string) $filename;
        if (!is_file($filename)) {
            throw new System_Db_Schema_Exception("File Not Found: '$filename'");
        }
        if (!is_readable($filename)) {
            throw new System_Db_Schema_Exception(
                "Permission Denied: '$filename'");
        }
        $pattern = "/-- migration $migration ([0-9]+).*/";
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $content = array();
        foreach ($lines as $number => $line) {
            if (preg_match($pattern, $line, $matches)) {
                for ($i = $number; $i < $number + $matches[1] + 1; $i++) {
                    $content[] = $lines[$i];
                }
            }
        }
        return implode(PHP_EOL, $content);
    }

    /**
     * Método Abstrato
     * Implementação de Alterações do Banco de Dados
     * @return mixed
     */
    abstract public function up();

    /**
     * Método Abstrato
     * Remoção de Alterações do Banco de Dados
     * @return mixed
     */
    abstract public function down();

}