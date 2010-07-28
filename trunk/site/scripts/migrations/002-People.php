<?php

/**
 * Tabela de Pessoas
 * Armazenamento de Usuários do Sistema
 * @author     Wanderson Henrique Camargo Rosa
 * @package    System
 * @subpackage Db
 * @see        http://code.google.com/p/wanderson/
 */
class People extends System_Db_Schema_AbstractChange
{
    /**
     * Arquivo para Leitura
     * @var string
     */
    protected $_filename = './scripts/build/structure-pgsql.sql';

    public function up()
    {
        $filename  = $this->_filename;
        $structure = $this->read($filename, 'people');
        $this->_db->query($structure);
        $structure = $this->read($filename, 'people-insert');
        $this->_db->query($structure);
    }

    public function down()
    {
        $filename  = $this->_filename;
        $structure = $this->read($filename, 'people-drop');
        $this->_db->query($structure);
    }
}