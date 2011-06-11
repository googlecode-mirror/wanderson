<?php

/**
 * Instituição Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Instituicao extends Local_Form_FormAbstract
{
    public function init()
    {
        // Endereço
        $endereco = new Zend_Dojo_Form_Element_Textarea('endereco');
        $endereco
            ->setLabel('Endereço')
            ->setRequired(true)
            ->setAllowEmpty(false)
            ->setDescription('Endereço Completo da Instituição');
        $this->addElement($endereco);

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}
