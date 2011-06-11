<?php

/**
 * Referência Controller
 * 
 * @category Application
 * @package  Application_Controller
 */
class ReferenciaController extends Local_Controller_ActionAbstract
{
    /**
     * Tabela Padrão de Banco de Dados
     * @var string
     */
    protected $_dbTableClass = 'Application_Model_DbTable_Referencia';

    /**
     * Formulário Padrão da Controladora
     * @var string
     */
    protected $_formClass = 'Application_Form_Referencia_Artigo';

    /**
     * Tipos de Referências Disponíveis
     * @var array
     */
    protected $_references = array('Artigo');

    /**
     * Captura um Formulário de Determinado Tipo
     * @param string Nome do Formulário
     * @return Local_Form_FormAbstract Elemento Solicitado
     */
    protected function _getFormReferencia($tipo)
    {
        // Filtro de Dados
        $filter = new Zend_Filter();
        $filter->addFilter(new Zend_Filter_StringToLower())
               ->addFilter(new Zend_Filter_Callback('ucfirst'));
        $tipo   = $filter->filter($tipo);
        // Verificação
        if (!in_array($tipo, $this->_references)) {
            throw new Zend_Controller_Action_Exception('Invalid Referencia');
        }
        $classname = 'Application_Form_Referencia_' . $tipo;
        $reflect = new Zend_Reflection_Class($classname);
        return $reflect->newInstance(array());
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        // Banco de Dados
        $table = $this->_getDbTable();
        $select = $table->select()->order('idreferencia ASC');
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
        // Anexo a Artigo
        $artigo = null;
        if ($this->_hasParam('idartigo')) {
            $idartigo = (int) $this->_getParam('idartigo');
            $tbArtigo = new Application_Model_DbTable_Artigo();
            $artigo   = $tbArtigo->find($idartigo)->current();
            if ($artigo === null) {
                throw new Zend_Db_Exception('Invalid Artigo Element');
            }
        }

        // Tipo da Referência
        $tipo = $this->_getParam('tipo', 'artigo');

        // Anexo ao Artigo
        $idartigo = (int) $this->_getParam('idartigo');
        $tbArtigo = new Application_Model_DbTable_Artigo();
        $artigo   = $tbArtigo->find($idartigo)->current();

        // Formulário
        $form = $this->_getFormReferencia($tipo);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Codificação
                $json = new Zend_Json();
                $conteudo = $json->encode($data['conteudo']);

                // Banco de Dados
                $table = $this->_getDbTable();
                $table->getAdapter()->beginTransaction();

                try {

                $element = $table->createRow();

                $element->tipo          = $data['tipo'];
                $element->identificador = $data['identificador'];
                $element->conteudo      = $conteudo;

                $element->save();

                // Artigo Informado ?
                if ($artigo !== null) {
                    $tbRArtigoReferencia = new Application_Model_DbTable_RArtigoReferencia();
                    $rArtigoReferencia   = $tbRArtigoReferencia->createRow();

                    $rArtigoReferencia->idartigo     = $artigo->idartigo;
                    $rArtigoReferencia->idreferencia = $artigo->idreferencia;

                    $rArtigoReferencia->save();
                }

                $table->getAdapter()->commit();
                } catch (Zend_Db_Exception $e) {
                    $table->getAdapter()->rollBack();
                    throw $e;
                }

                $this->_helper->flashMessenger('insert');
                $this->_helper->redirector('index');

            }
        }

        // Camada de Visualização
        $this->view->form = $form;
    }

    /**
     * Edit Action
     * @todo Reaproveitamento de Código em Salvar
     */
    public function editAction()
    {
        // Chaves Primárias
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
        $form = $this->_getFormReferencia($element->tipo);

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Codificação
                $json = new Zend_Json();
                $conteudo = $json->encode($data['conteudo']);

                $element->tipo          = $data['tipo'];
                $element->identificador = $data['identificador'];
                $element->conteudo      = $conteudo;

                $element->save();

                $this->_helper->flashMessenger('update');
                $this->_helper->redirector('index');
            }
        } else {

            // População
            $form->tipo->setValue($element->tipo);
            $form->identificador->setValue($element->identificador);

            $json = new Zend_Json();
            $conteudo = $json->decode($element->conteudo);
            foreach ($conteudo as $field => $content) {
                $form->conteudo->getElement($field)->setValue($content);
            }

        }

        $this->view->form = $form;
    }

    /**
     * Remove Action
     */
    public function removeAction()
    {
        // Chaves Primárias
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Recuperação do Elemento
        $table = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Remoção do Elemento no Banco
        $element->delete();

        // Mensagens
        $this->_helper->flashMessenger('delete');
        $this->_helper->redirector('index');
    }
}
