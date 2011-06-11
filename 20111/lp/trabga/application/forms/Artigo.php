<?php

/**
 * Artigo Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Artigo extends Application_Form_Referencia
{
    public function init()
    {
        // Construção de Elementos Básicos
        parent::init();

        // Campos Adicionais
        $fields = array(
            'article' => 'Artigo',
            'title'   => 'Título',
            'journal' => 'Revista',
            'year'    => 'Ano',
        );
        $this->addFields($fields);

        // Configuração do Tipo
        $this->getElement('tipo')->setValue('artigo');

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}
