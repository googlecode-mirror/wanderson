<?php

/**
 * Usuario Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Usuario extends Local_Form_FormAbstract
{
    public function init()
    {
        $info = new Application_Form_UsuarioInfo();
        $info->removeElement('submit');
        $this->addSubForm($info, 'info');

        $ativado = new Zend_Dojo_Form_Element_CheckBox('ativado');
        $ativado->setLabel('Ativo no Sistema')
                ->addFilter(new Zend_Filter_Boolean());
        $this->addElement($ativado);

        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}