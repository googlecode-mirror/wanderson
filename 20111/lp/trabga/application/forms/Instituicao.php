<?php

/**
 * Instituição Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Instituicao extends Zend_Dojo_Form
{
    public function init()
    {
        // Configurações Locais
        $this->setMethod(self::METHOD_POST)->setAction($this->getView()->url());

        // Endereço
        $endereco = new Zend_Dojo_Form_Element_Textarea('endereco');
        $endereco
            ->setLabel('Endereço')
            ->setRequired(true)
            ->setAllowEmpty(false)
            ->setDescription('Endereço Completo da Instituição');
        $this->addElement($submit);

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $submit->setLabel('Salvar');
        $this->addElement($submit);
    }
}
