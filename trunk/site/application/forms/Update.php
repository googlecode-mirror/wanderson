<?php

/**
 * 
 * Formulário de Atualização do Sistema
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Form
 * @see        http://code.google.com/p/wanderson/
 */
class Application_Form_Update extends Zend_Dojo_Form
{

    /**
     * Inicialização do Formulário
     * @return void
     */
    public function init()
    {
        $this->loadDefaultDecorators();
        $this->setName('form-update')->setMethod(self::METHOD_POST)
            ->setAction($this->getView()->url());

        $filter  = new Zend_Filter_Decompress('Zip');
        $filter->setTarget(Zend_Registry::get('APPLICATION_TEMP'));
        $arquivo = new Zend_Form_Element_File('arquivo');
        $arquivo->setLabel('Arquivo de Atualização')->setRequired(true)
            ->setDestination(Zend_Registry::get('APPLICATION_TEMP'))
            ->setMaxFileSize(1024 * 500)->addFilter($filter)
            ->addValidator(new Zend_Validate_File_Count(1))
            ->addValidator(new Zend_Validate_File_Extension('zip'))
            ->setDescription('Arquivo compactado no formato *.zip');

        $submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
        $submit->setLabel('Enviar')->setIgnore(true);

        $elements = array($arquivo,$submit);
        $this->addElements($elements);
    }

}
