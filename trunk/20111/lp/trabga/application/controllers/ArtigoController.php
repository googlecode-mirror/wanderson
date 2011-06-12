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
        // Banco de Dados
        $table  = $this->_getDbTable();
        $select = $table->select()->order('idartigo');
        $result = $table->fetchAll($select);

        // Requisição Ajax
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->json($result->toArray());
        }

        // Mensagens
        $messages = $this->_helper->flashMessenger->getMessages();

        // Camada de Visualização
        $this->view->result = $result;
        $this->view->messages = $messages;
    }

    /**
     * Create Action
     */
    public function createAction()
    {
        // Requisição Ajax
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
            Zend_Dojo_View_Helper_Dojo::setUseDeclarative();
        }

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
                $element->save();

                if ($this->getRequest()->isXmlHttpRequest()) {
                    $messages = array('insert');
                    $this->_helper->json(array(
                        'messages' => $messages,
                        'idartigo' => $element->idartigo,
                        'titulo'   => $element->titulo
                    ));
                }

                $this->_helper->flashMessenger('insert');
                $this->_helper->redirector('edit', null, null, array(
                    'idartigo' => $element->idartigo
                ));
            }
        }

        // Camada de Visualização
        $this->view->form = $form;
    }

    /**
     * Edit Action
     */
    public function editAction()
    {
        // Requisição Ajax
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
            Zend_Dojo_View_Helper_Dojo::setUseDeclarative();
        }

        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Mensagens Disponíveis
        // FlashMessenger sem Nova Requisição
        $messages = array();

        // Banco de Dados
        $table   = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Formulário
        $form = $this->_getForm();

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                $element->titulo = $data['cabecalho']['titulo'];
                $element->conteudo = $data['conteudo'];
                $element->save();

                $messages[] = 'update';

                if ($this->getRequest()->isXmlHttpRequest()) {
                    // Resposta como Json para Ajax
                    $this->_helper->json(array('messages'=> $messages));
                }

            }
        } else {
            // População
            $form->cabecalho->titulo->setValue($element->titulo);
            $form->conteudo->setValue($element->conteudo);
        }

        // Camada de Visualização
        $this->view->form = $form;
        $this->view->messages = $messages;
    }

    /**
     * Service Action
     */
    public function serviceAction()
    {
        // Requisição Ajax
        $this->view->layout()->disableLayout();

        // Renderização de Títulos
        $table  = $this->_getDbTable();
        $select = $table->select()->order('idartigo ASC');
        $result = $table->fetchAll($select);

        // Camada de Visualização
        $this->view->result = $result;
    }
}