<?php

class Schema extends System_Db_Schema_AbstractChange
{
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
        $structure = $this->read($filename, 'drop-schema');
        $this->_db->query($structure);
    }
}