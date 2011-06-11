<?php

/**
 * Referência Form
 * 
 * @category Application
 * @package  Application_Form
 */
abstract class Application_Form_Referencia extends Local_Form_FormAbstract
{
    /**
     * Tipos Válidos
     * @var array
     */
    protected $_tipos = array('artigo');

    public function init()
    {
        // Tipo de Referência
        $tipo = new Local_Form_Element_Hidden('tipo');
        $tipo->addValidator(new Zend_Validate_InArray($this->_tipos));
        $this->addElement($tipo);

        // Identificador
        $identificador = new Application_Form_Element_Label('identificador');
        $identificador
            ->setLabel('Identificador')
            ->setDescription('Texto Único para Referência Cruzada');
        $this->addElement($identificador);
    }

    /**
     * Inclusão de Elementos
     * @param array $fields Conjunto de Identificadores e Conteúdo
     * @return Application_Form_Referencia Próprio Objeto para Encadeamento
     */
    public function addFields(array $fields)
    {
        $form = new Zend_Form_SubForm();
        foreach ($fields as $identifier => $content) {
            $element = new Zend_Dojo_Form_Element_TextBox($identifier);
            $element->setLabel($content)
                    ->setRequired(true);
            $form->addElement($element);
        }
        $this->addSubForm($form, 'conteudo');
        return $this;
    }
}
