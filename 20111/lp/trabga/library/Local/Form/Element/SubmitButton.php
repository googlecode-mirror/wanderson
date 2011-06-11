<?php

/**
 * Botão para Envio de Formulários
 * 
 * Elemento de formulário que facilita a construção de botões que são ignorados
 * em tempo de solicitação dos dados enviados na conexão.
 * 
 * @category   Local
 * @package    Local_Form
 * @subpackage Element
 */
class Local_Form_Element_SubmitButton extends Zend_Dojo_Form_Element_SubmitButton
{
    public function init()
    {
        $this->setRequired(false)->setIgnore(true)->setLabel('Salvar');
    }
}