<?php

/**
 * Formulário de Categorias
 *
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_Form
 * 
 * @property Zend_Form_Element_Hidden $idcategory
 * @property Zend_Form_Element_Text $name
 * @property Zend_Form_Element_Text $submit
 */
class Publisher_Form_Category extends Zend_Form
{
    public function init()
    {
        /*
         * Configurações Iniciais do Formulário
         */
        $this->loadDefaultDecorators();
        $this->setName('publisher_form_category')->setMethod(self::METHOD_POST)
            ->setAction($this->getView()->url());

        /*
         * Chave Primária
         */
        $idcategory = new Zend_Form_Element_Hidden('idcategory');
        $idcategory->removeDecorator('Label')->addFilter(new Zend_Filter_Int())
            ->addFilter(new Zend_Filter_Null());

        /*
         * Nome da Categoria
         */
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Nome')->addFilter(new Zend_Filter_Alnum(true))
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_NotEmpty())
            ->addValidator(new Zend_Validate_StringLength(1,50));

        /*
         * Envio de Formulário
         */
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar')->setIgnore(true);

        /*
         * Adição dos Elementos Criados
         */
        $elements = array($idcategory, $name, $submit);
        $this->addElements($elements);
    }
}