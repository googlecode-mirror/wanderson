<?php

/**
 * Criação de Artigo Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_ArtigoTitulo extends Local_Form_FormAbstract
{
    public function init()
    {
        // Título
        $titulo = new Zend_Dojo_Form_Element_TextBox('titulo');
        $titulo->setLabel('Título')
               ->setDescription('Nome Completo do Artigo')
               ->setRequired(true)
               ->setAllowEmpty(false)
               ->addValidator(new Zend_Validate_StringLength(1,100))
               ->addFilter(new Zend_Filter_Alnum(true))
               ->addFilter(new Zend_Filter_StringTrim())
               ->setMaxLength(100);
        $this->addElement($titulo);

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}
