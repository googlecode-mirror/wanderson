<?php

/**
 * 
 * Controladora Administrativa
 * Administração do Sistema Sobre Usuários e Elementos Restritos
 * @author     Wanderson Henrique Camargo Rosa
 * @package    Application
 * @subpackage Controller
 * @see        http://code.google.com/p/wanderson/
 */
class AdminController extends Zend_Controller_Action
{

    /**
     * 
     * Inicialização da Controladora
     * @return void
     */
    public function init()
    {
        
    }

    /**
     * 
     * Ação Principal da Controladora
     * @return void
     */
    public function indexAction()
    {
        
    }

    /**
     * 
     * Ação para Atualização do Sistema
     * Recebe um Arquivo Compactado com as Modificações do Projeto
     * @return void
     */
    public function updateAction()
    {
        $form = new Application_Form_Update();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();
            }
        }
        $this->view->form = $form;
    }

}
