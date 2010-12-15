<?php

class Admin_Form_Password extends Zend_Form
{
    public function init()
    {
        $this->loadDefaultDecorators();
        $this
            ->setName('admin-password')
            ->setMethod(self::METHOD_POST)
            ->setAction($this->getView()->url())
            ->setLegend('Senha')
            ->addDecorator('Fieldset')
            ->addDecorator('Errors');

        $newest = new Zend_Form_Element_Password('newest');
        $newest
            ->setLabel('Nova Senha')
            ->setRenderPassword(false)
            ->setRequired(true)
            ->addValidator(new Zend_Validate_NotEmpty());

        $repeat = new Zend_Form_Element_Password('repeat');
        $repeat
            ->setLabel('Repita a Nova Senha')
            ->setRenderPassword(false)
            ->addFilter(new Zend_Filter_Callback('md5'));

        $submit = new Zend_Form_Element_Submit('admin-password-submit');
        $submit
            ->setLabel('Salvar')
            ->setIgnore(true);

        $elements = array($newest, $repeat, $submit);
        $this->setElements($elements);
    }

    /**
     * Sobrescrita de Método para Confirmação de Senha
     * 
     * @param $data Dados para Validação
     * @return boolean
     */
    public function isValid($data)
    {
        $result = parent::isValid($data);
        if ($result) {
            $result = $this->getValue('newest')
                == $this->getUnfilteredValue('repeat');
            if (!$result) {
                $this->getElement('repeat')->addError('Senha Não Confere');
            }
        }
        return $result;
    }
}