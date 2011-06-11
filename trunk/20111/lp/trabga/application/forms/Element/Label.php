<?php

/**
 * Etiqueta para Referências Cruzadas
 * 
 * Extensão que permite a utilização de componentes de formulários para informar
 * possíveis etiquetas (labels) que serão utilizadas nas referências cruzadas.
 * 
 * @category   Application
 * @package    Application_Form
 * @subpackage Element
 */
class Application_Form_Element_Label extends Zend_Dojo_Form_Element_ValidationTextBox
{
    public function init()
    {
        // Formulário Simples
        $this->setRequired(true)
             ->addValidator(new Zend_Validate_Regex('/^[a-z]{1,100}$/'))
             ->addFilter(new Zend_Filter_StringTrim())
             ->addFilter(new Zend_Filter_PregReplace('/(  )+/', ''));

        // Extensão Dojo Toolkit
        $this->setRegExp('[a-z]{1,100}')->setLowercase(true)->setTrim(true);
    }
}