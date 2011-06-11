<?php

/**
 * Artigo Controller
 * 
 * @category Application
 * @package  Application_Controller
 */
class ArtigoController extends Local_Controller_ActionAbstract
{
    /**
     * Tabela Padrão de Banco de Dados
     * @var string
     */
    protected $_dbTableClass = 'Application_Model_DbTable_Artigo';

    /**
     * Formulário Padrão da Controladora
     * @var string
     */
    protected $_formClass = 'Application_Form_Artigo';

    /**
     * Index Action
     */
    public function indexAction()
    {
        
    }

    /**
     * Create Action
     */
    public function createAction()
    {
        // Formulário
        $form = new Application_Form_ArtigoTitulo();

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                $table = $this->_getDbTable();
                $element = $table->createRow();

                $element->titulo = $data['titulo'];
                $element->idusuario = 1; // @todo Identificador do Usuário
                $element->save();

                $this->_helper->flashMessenger('insert');
                $this->_helper->redirector('index');
            }
        }

        // Camada de Visualização
        $this->view->form = $form;
    }
}
