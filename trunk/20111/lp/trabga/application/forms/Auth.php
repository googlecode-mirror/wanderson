<?php

/**
 * Formulário de Autenticação
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Auth extends Local_Form_FormAbstract
{
    public function init()
    {
        // Identidade do Usuário
        $identidade = new Zend_Dojo_Form_Element_TextBox('identidade');
        $identidade->setLabel('Nome do Usuário')->setRequired(true);
        $this->addElement($identidade);

        // Credenciais
        $credencial = new Zend_Dojo_Form_Element_PasswordTextBox('credencial');
        $credencial->setLabel('Senha');
        $this->addElement($credencial);

        // Botão de Envio
        $submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
        $submit->setLabel('Entrar')->setIgnore(true);
        $this->addElement($submit);
    }
}
