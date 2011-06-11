<?php

/**
 * Artigo Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Artigo extends Local_Form_FormAbstract
{
    public function init()
    {
        // Cabeçalho
        $titulo = new Application_Form_ArtigoTitulo();
        $titulo->removeElement('submit');
        $this->addSubForm($titulo, 'cabecalho');

        // Corpo do Documento
        $conteudo = new Zend_Dojo_Form_Element_Textarea('conteudo');
        $conteudo->setLabel('Conteúdo')
                 ->setDescription('Corpo do Documento');
        $this->addElement($conteudo);

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}
