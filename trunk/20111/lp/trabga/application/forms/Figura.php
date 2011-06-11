<?php

/**
 * Figura Form
 *
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Figura extends Zend_Dojo_Form
{
    public function init()
    {
        // Configurações Locais
        $this->setMethod(self::METHOD_POST)->setAction($this->getView()->url());

        // Identificador
        $identificador = new Application_Form_Element_Label('identificador');
        $identificador
            ->setLabel('Identificador')
            ->setDescription('Texto Único para Referência Cruzada');
        $this->addElement($identificador);

        // Legenda da Imagem
        $legenda = new Zend_Dojo_Form_Element_TextBox('legenda');
        $legenda
            ->setLabel('Legenda')
            ->setDescription('Texto Exibido Abaixo da Figura')
            ->addValidator(new Zend_Validate_StringLength(0,100))
            ->addFilter(new Zend_Filter_StringTrim())
            ->setTrim(true)
            ->setMaxLength(100);
        $this->addElement($legenda);

        // Extensões Habilitadas
        $extension = array('jpg','gif','png', 'case' => 'sensitive');
        // Arquivo
        $arquivo = new Zend_Form_Element_File('arquivo');
        $arquivo
            ->addValidator(new Zend_Validate_File_Count(1))
            ->addValidator(new Zend_Validate_File_Extension($extension))
            ->setDestination(APPLICATION_PATH . '/../temp')
            ->setRequired(true)
            ->setMaxFileSize(1024 * 500) // 500 KB
            ->setLabel('Imagem para Exibição')
            ->setDescription('Arquivo Correspondente da Imagem');
        $this->addElement($arquivo);

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $submit->setLabel('Salvar');
        $this->addElement($submit);
    }
}
