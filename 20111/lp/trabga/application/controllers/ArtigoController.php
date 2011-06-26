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
     * Tradutor de Artigos
     * @var Local_Parser_WikiToLatex
     */
    protected $_parser;

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

            }
        } else {
            // População
            $form->cabecalho->titulo->setValue($element->titulo);
            $form->conteudo->setValue($element->conteudo);
        }

        // Habilitando Migalha
        $this->view->navigation()
             ->findOneBy('active', true)->setVisible(true);

        // Camada de Visualização
        $this->view->form = $form;
        $this->view->messages = $messages;
    }

    /**
     * Remove Action
     */
    public function removeAction()
    {
        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Recuperação de Elemento
        $table = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Remoção do Elemento do Banco
        $element->delete();

        // Mensagens
        $this->_helper->flashMessenger('delete');
        $this->_helper->redirector('index');
    }

    /**
     * Export Action
     */
    public function exportAction()
    {
        // Chave Primária
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Recuperação de Elemento
        $table = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Dependências
        Zend_Loader::loadFile('antlr.php', null, true);
        Zend_Loader::loadClass('SubWikiParser');
        Zend_Loader::loadClass('SubWikiLexer');

        // Inicialização
        $ass = new ANTLRStringStream($element->conteudo);
        $lex = new SubWikiLexer($ass);
        $cts = new CommonTokenStream($lex);

        // Tradutor
        $parser = new SubWikiParser($cts);

        // Usuário Atual
        $usuario = $element->findParentRow('Usuario');

        // Preenchimento de Imagens Disponíveis
        $figuras = $usuario->findDependentRowset('Figura');
        foreach ($figuras as $figura) {
            $identifier = $figura->identificador;
            $filename   = $figura->arquivo;
            $caption    = $figura->legenda;
            $parser->addImageInfo($identifier, $filename, $caption);
        }

        // Preenchimento de Citações Disponíveis
        $referencias = $usuario->findDependentRowset('Referencia');
        foreach ($referencias as $referencia) {
            $identifier = $referencia->identificador;
            $parser->addCiteInfo($identifier);
        }

        // Processamento
        $parser->wikipage();

        // Ignorar Renderização de Saída
        $renderer = $this->_helper->getHelper('ViewRenderer');
        $renderer->setNoRender(true);
        $this->view->layout()->disableLayout();
    }
}