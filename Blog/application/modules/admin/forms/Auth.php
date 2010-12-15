<?php

class Admin_Form_Auth extends Zend_Form
{
    public function init()
    {
        $this->loadDefaultDecorators();
        $this
            ->setName('admin-auth')
            ->setMethod(self::METHOD_POST)
            ->setAction($this->getView()->url())
            ->setLegend('Entrar no Sistema')
            ->addDecorator('Fieldset');

        $username = new Zend_Form_Element_Text('username');
        $username
            ->setLabel('Usuário')
            ->setRequired(true);

        $password = new Zend_Form_Element_Password('password');
        $password
            ->setLabel('Senha')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_Callback('md5'));

        $submit = new Zend_Form_Element_Submit('admin-auth-submit');
        $submit
            ->setLabel('Entrar')
            ->setIgnore(true);

        $elements = array($username, $password, $submit);
        $this->addElements($elements);
    }
}