<?php

class Admin_Form_User extends Zend_Form
{
    public function init()
    {
        $this->loadDefaultDecorators();
        $this
            ->setName('admin-user')
            ->setMethod(self::METHOD_POST)
            ->setAction($this->getView()->url())
            ->setLegend('Usuário')
            ->addDecorator('Fieldset')
            ->addDecorator('Errors');

        $username = new Zend_Form_Element_Text('username');
        $username
            ->setLabel('Usuário')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_Alnum(false))
            ->addValidator(new Zend_Validate_StringLength(1,20))
            ->addFilter(new Zend_Filter_StringToLower());

        $displayname = new Zend_Form_Element_Text('displayname');
        $displayname
            ->setLabel('Nome Completo')
            ->addValidator(new Zend_Validate_Alpha(true))
            ->addValidator(new Zend_Validate_StringLength(1,100));

        $active = new Zend_Form_Element_Checkbox('active');
        $active
            ->setLabel('Ativado')
            ->setChecked(true)
            ->addFilter(new Zend_Filter_Boolean());

        $submit = new Zend_Form_Element_Submit('admin-user-submit');
        $submit
            ->setLabel('Salvar')
            ->setIgnore(true);

        $elements = array($username, $displayname, $active, $submit);
        $this->addElements($elements);
    }
}