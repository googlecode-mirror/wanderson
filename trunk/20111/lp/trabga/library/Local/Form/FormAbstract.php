<?php

/**
 * Formulário Local Abstrato
 * 
 * Inicializa antes da construção sobrescrita a inicialização do método de envio
 * do formulário e ação padrão como a página em que está sendo exibido.
 * 
 * @category   Local
 * @package    Local_Form
 * @subpackage Form
 */
abstract class Local_Form_FormAbstract extends Zend_Dojo_Form
{
    public function __construct($options = null)
    {
        // Configurações Iniciais
        $this->setMethod(self::METHOD_POST)->setAction($this->getView()->url());
        // Superclasse
        parent::__construct($options);
    }
}