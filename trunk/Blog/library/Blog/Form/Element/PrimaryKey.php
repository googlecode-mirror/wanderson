<?php

class Blog_Form_Element_PrimaryKey extends Zend_Form_Element_Hidden
{
    public function init()
    {
        $this
            ->addFilter(new Zend_Filter_Int())
            ->addFilter(new Zend_Filter_Null())
            ->removeDecorator('Label');
    }
}