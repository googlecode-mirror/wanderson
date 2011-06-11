<?php

/**
 * Autor Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Autor extends Local_Form_FormAbstract
{
    public function init()
    {
        // Nome
        $nome = new Zend_Dojo_Form_Element_TextBox('nome');
        $nome->setLabel('Nome')
             ->setDescription('Nome do Autor')
             ->addValidator(new Zend_Validate_StringLength(0,100))
             ->addValidator(new Zend_Validate_Alpha(true))
             ->addFilter(new Zend_Filter_StringTrim())
             ->setRequired(true);
        $this->addElement($nome);

        // Email
        $tbAutor = new Application_Model_DbTable_Autor();
        $options = array(
            'table'  => $tbAutor->info(Zend_Db_Table::NAME),
            'schema' => $tbAutor->info(Zend_Db_Table::SCHEMA),
            'field'  => 'email',
        );
        $email = new Zend_Dojo_Form_Element_TextBox('email');
        $email->setLabel('Email')
              ->setDescription('Email para Contato')
              ->addValidator(new Zend_Validate_EmailAddress())
              ->addValidator(new Zend_Validate_StringLength(1,100))
              ->addValidator(new Local_Validate_Db_NoRecordExists($options))
              ->addFilter(new Zend_Filter_StringTrim())
              ->setRequired(true);
        $this->addElement($email);

        // Instituição
        $instituicao = new Application_Form_Instituicao();
        $instituicao->removeElement('submit');
        $this->addSubForm($instituicao, 'instituicao');

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}
