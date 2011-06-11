<?php

/**
 * Figura Controller
 * 
 * @category Application
 * @package  Application_Controller
 */
class FiguraController extends Local_Controller_ActionAbstract
{
    /**
     * Nome da Classe Padrão de Tabela
     * @var string
     */
    protected $_dbTableClass = 'Application_Model_DbTable_Figura';

    /**
     * Nome da Classe Padrão de Formulários
     * @var string
     */
    protected $_formClass = 'Application_Form_Figura';

    /**
     * Realoca uma Imagem do Formulário
     * @param string $filename Novo Nome do Arquivo
     * @return string|boolean Resultado Obtido
     */
    protected function _realloc($prefix)
    {
        /* @var $arquivo Zend_Form_Element_File */
        $arquivo = $this->_getForm()->getElement('arquivo');
        if (is_array($arquivo->getFilename())) {
            // Não Enviado
            return false;
        }

        // Diretório Base
        $basename = APPLICATION_PATH . '/../public/images/sistema/';

        // Remover Figuras com Prefixo
        $dir = new DirectoryIterator($basename);
        foreach ($dir as $current) {
            if (preg_match('/^' . $prefix . '/', $current->getFilename())) {
                unlink($current->getRealPath());
            }
        }

        // Criação do Slug
        $filter = new Zend_Filter();
        $filter->addFilter(new Zend_Filter_StringToLower())
               ->addFilter(new Zend_Filter_Word_SeparatorToDash());
        $slug   = $filter->filter($prefix . ' ' . $arquivo->getFilename(null, false));

        // Opções para Filtro
        $options = array(
            'target' => $basename . $slug,
            'overwrite' => true
        );

        // Renomear Arquivo
        $rename = new Zend_Filter_File_Rename($options);
        $result = $rename->filter($arquivo->getFilename());

        return is_string($result) ? $slug : false;
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        // Banco de Dados
        $table  = $this->_getDbTable();
        $select = $table->select()->order('idfigura ASC');
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
        $form = $this->_getForm();
        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                // Dados Validados
                $data = $form->getValues();

                // Banco de Dados
                $table = $this->_getDbTable();
                $table->getAdapter()->beginTransaction();
                try {
                    $element = $table->createRow($data);
                    $element->save();
                    // Alocar Imagem no Público
                    $slug = $this->_realloc($element->idfigura);
                    if (!is_string($slug)) {
                        throw new Zend_Db_Exception('Invalid Filename');
                    }
                    $element->arquivo = $slug;
                    $element->save();
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
     */
    public function editAction()
    {
        // Chaves Primárias
        $primaries = $this->_getPrimaries(function($value){
            return (int) $value;
        });

        // Recuperação do Elemento
        $table   = $this->_getDbTable();
        $element = $table->find($primaries)->current();

        // Verificação
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Formulário
        $form = $this->_getForm();
        // Não Sobrescrever Figura
        $form->arquivo->setRequired(false);

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Banco de Dados
                $table->getAdapter()->beginTransaction();
                try {
                    unset($data['arquivo']); // Evitar Sobrescrita
                    $element->setFromArray($data);
                    $element->save();
                    // Alocar Imagem no Público
                    $slug = $this->_realloc($element->idfigura);
                    if ($slug !== false) {
                        $element->arquivo = $slug;
                        $element->save();
                    }
                    $table->getAdapter()->commit();
                } catch (Zend_Db_Exception $e) {
                    $table->getAdapter()->rollBack();
                    throw $e;
                }

                $this->_helper->flashMessenger('update');
                $this->_helper->redirector('index');
            }
        } else {
            // Requisição de Dados
            $form->populate($element->toArray());
        }

        // Camada de Visualização
        $this->view->form = $form;
        $this->view->element = $element;
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

        // Elemento Inexistente
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Caminho Real para o Arquivo
        $dirname = realpath(APPLICATION_PATH . '/../public/images/sistema/');
        unlink($dirname . '/' . $element->arquivo);

        // Remoção do Elemento no Banco
        // Mensagens
        $element->delete();

        // Mensagens
        $this->_helper->flashMessenger('delete');
        $this->_helper->redirector('index');
    }
}
