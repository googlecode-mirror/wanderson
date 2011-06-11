<?php

/**
 * Elemento Escondido
 * 
 * @category   Local
 * @package    Local_Form
 * @subpackage Element
 */
class Local_Form_Element_Hidden extends Zend_Form_Element_Hidden
{
    public function init()
    {
        $this->setRequired(true)->removeDecorator('Label');
    }
}