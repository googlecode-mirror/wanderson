<?php

/**
 * People Database Table Row
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Blog
 * @package    Blog_Model
 * @subpackage DbTable
 */
class Blog_Model_DbTable_Row_People extends Zend_Db_Table_Row_Abstract
{
    public function save()
    {
        // Checagem de Codificação MD5
        if (!preg_match('/^[a-fA-F0-9]{32}$/', $this->password)) {
            $this->password = md5($this->password);
        }
        return parent::save();
    }

    public function delete()
    {
        $this->active = false;
        $this->removed = true;
        $this->save();
        return 1;
    }
}