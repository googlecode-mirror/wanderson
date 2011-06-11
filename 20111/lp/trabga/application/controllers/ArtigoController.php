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
        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

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

                $this->_helper->flashMessenger('update');
                $this->_helper->redirector('index');

            }
        } else {
            // População
            $form->cabecalho->titulo->setValue($element->titulo);
            $form->conteudo->setValue($element->conteudo);
        }

        // Anexos
        $figuras     = $element->findManyToManyRowset('Figura','RArtigoFigura');
        $referencias = $element->findManyToManyRowset('Referencia','RArtigoReferencia');

        // Camada de Visualização
        $this->view->form = $form;
        $this->view->figuras = $figuras;
        $this->view->referencias = $referencias;
    }
}