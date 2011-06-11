<?php

/**
 * Usuário Form
 * 
 * @category Application
 * @package  Application_Form
 */
class Application_Form_Usuario extends Local_Form_FormAbstract
{
    public function init()
    {
        // Identidade
        $identidade = new Zend_Dojo_Form_Element_TextBox('identidade');
        $identidade->setLabel('Usuário')
                   ->setDescription('Nome do Usuário para Acessar o Sistema');
        $this->addElement($identidade);

        // Credenciais
        $credencial = new Zend_Dojo_Form_Element_PasswordTextBox('credencial');
        $credencial->setLabel('Senha')
                   ->setDescription('Credenciais para Autenticação')
                   ->addFilter(new Zend_Filter_Null());
        $this->addElement($credencial);

        // Autor
        $autor = new Application_Form_Autor();
        $autor->removeElement('submit');
        $this->addSubForm($autor, 'autor');

        // Botão de Envio
        $submit = new Local_Form_Element_SubmitButton('submit');
        $this->addElement($submit);
    }
}
