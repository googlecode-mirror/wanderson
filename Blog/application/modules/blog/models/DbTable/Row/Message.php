<?php

/**
 * Message Database Table Row
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Blog
 * @package    Blog_Model
 * @subpackage DbTable
 */
class Blog_Model_DbTable_Row_Message extends Zend_Db_Table_Row_Abstract
{
    public function save()
    {
        if ($this->created === null) {
            unset($this->created);
        }
        if (empty($this->idpeople) || !is_numeric($this->idpeople)) {
            $this->idpeople = null;
        }
        if (empty($this->ip)) {
            $front = Zend_Controller_Front::getInstance();
            $this->ip = $front->getRequest()->getClientIp();
        }
        return parent::save();
    }
}