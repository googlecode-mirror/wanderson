<?php

/**
 * Esquema Base para Banco de Dados
 * @author     Wanderson Henrique Camargo Rosa
 * @package    System
 * @subpackage Db
 * @see        http://code.google.com/p/wanderson/
 */
class Schema extends System_Db_Schema_AbstractChange
{
    /**
     * Arquivo para Leitura
     * @var string
     */
    protected $_filename = './scripts/build/structure-pgsql.sql';

    public function up()
    {
        $filename  = $this->_filename;
        $structure = $this->read($filename, 'schema');
        $this->_db->query($structure);
    }

    public function down()
    {
        $filename  = $this->_filename;
        $structure = $this->read($filename, 'schema-drop');
        $this->_db->query($structure);
    }
}