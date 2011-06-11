<?php

/**
 * Usuário Controller
 * 
 * @category Application
 * @package  Application_Controller
 */
class UsuarioController extends Local_Controller_ActionAbstract
{
    /**
     * Nome do Formulário Padrão da Controladora
     * @var string
     */
    protected $_formClass = 'Application_Form_Usuario';

    /**
     * Nome da Tabela Padrão da Controladora
     * @var string
     */
    protected $_dbTableClass = 'Application_Model_DbTable_Usuario';

    /**
     * Index Action
     */
    public function indexAction()
    {
        // Formulário
        $form = $this->_getForm();

        // Ignorar Nome de Usuário
        $form->identidade->setIgnore(true);

        if ($this->getRequest()->isPost()) {
            // Dados Enviados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Filtro Inicial
                Zend_Debug::dump($data);

            }
        }

        // Nome do Usuário é Preenchido e Desabilitado
        $form->identidade
             ->setValue('wandersonwhcr')
             ->setAttrib('disabled', true);

        // Camada de Visualização
        $this->view->form = $form;
    }
}
