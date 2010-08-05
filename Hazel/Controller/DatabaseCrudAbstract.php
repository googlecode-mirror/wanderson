<?php
/**
 * Hazel Zend Framework Extended Library
 * 
 * LICENSE
 * 
 * Copyright (c) 2010, Wanderson Henrique Camargo Rosa.
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permited provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 * 
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 * 
 *     * Neither the name of the author nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * Zend Framework
 * Copyright (c) Zend Technologies Ltd. All rights reserved.
 * 
 * @category Hazel
 * @package  Hazel_Controller
 * @author   Wanderson Henrique Camargo Rosa
 * @link     http://code.google.com/p/wanderson/wiki/Hazel
 */

/**
 * Hazel Database CRUD Controller
 * 
 * Controladora para Elementos Provenientes de Banco de Dados
 * 
 * @category Hazel
 * @package  Hazel_Controller
 * @author   Wanderson Henrique Camargo Rosa
 * @link     http://code.google.com/p/wanderson/wiki/Hazel
 */
abstract class Hazel_Controller_DatabaseCrudAbstract
    extends Zend_Controller_Action
{
    /**
     * Atualização de Elemento com Sucesso
     * @var string
     */
    const MESSAGE_UPDATE_SUCCESS = 'MESSAGE_UPDATE_SUCCESS';

    /**
     * Atualização de Elemento com Erro
     * @var string
     */
    const MESSAGE_UPDATE_ERROR   = 'MESSAGE_UPDATE_ERROR';

    /**
     * Remoção de Elemento com Sucesso
     * @var string
     */
    const MESSAGE_DELETE_SUCCESS = 'MESSAGE_DELETE_SUCCESS';

    /**
     * Remoção de Elemento com Erro
     * @var string
     */
    const MESSAGE_DELETE_ERROR   = 'MESSAGE_DELETE_ERROR';

    /**
     * Criação de Elemento com Sucesso
     * @var string
     */
    const MESSAGE_CREATE_SUCCESS = 'MESSAGE_CREATE_SUCCESS';

    /**
     * Criação de Elemento com Erro
     * @var string
     */
    const MESSAGE_CREATE_ERROR   = 'MESSAGE_CREATE_ERROR';

    /**
     * Nome da Classe Representante da Tabela no Banco de Dados
     * @var string
     */
    protected $_dbtable = null;

    /**
     * Formulário para Manipulações de Valores dos Elementos
     * @var string
     */
    protected $_form = null;

    /**
     * Colunas para Exibição na Grade de Elementos
     * @var array
     */
    protected $_columns = array();

    /**
     * Monta o Nome do Elemento Solicitado para o Pacote
     * @param string $name Elemento para Montagem
     * @return string Nome do Elemento Montado
     * @throws Hazel_Controller_Exception Invalid Bootstrap
     */
    protected function _getPackageElement($name)
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if ($bootstrap == null) {
            throw new Hazel_Controller_Exception('Invalid Bootstrap');
        }
        $package = explode('_', get_class($this));
        $stack   = array();
        if (count($package) > 1) {
            array_push($stack, array_shift($package));
        } elseif ($namespace = $bootstrap->getAppNamespace()) {
            array_push($stack, $namespace);
        }
        $entity  = str_replace('Controller', null, array_pop($package));
        array_push($stack, $name, $entity);
        return implode('_', $stack);
    }

    /**
     * Monta a Pesquisa de Elementos do Banco de Dados
     * @return Zend_Db_Table_Select Objeto para Consulta
     */
    protected function _getRetrieveSelect()
    {
        $table  = $this->getDbTable();
        $order  = $this->_getParam('order');
        $select = $table->select();
        if (in_array($order, $table->info(Zend_Db_Table::COLS))) {
            $select->order($order);
        }
        return $select;
    }

    /**
     * Criação de Objeto de Tabela do Banco de Dados
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if ($this->_dbtable == null) {
            $this->_dbtable = $this->_getPackageElement('Model_DbTable');
        }
        $name    = $this->_dbtable;
        $element = new $name();
        return $element;
    }

    /**
     * Pesquisa de Elemento no Banco de Dados Conforme Parâmetros
     * @return Zend_Db_Table_Row_Abstract
     * @throws Hazel_Controller_Exception Elemento Inválido
     */
    public function getElement()
    {
        $table     = $this->getDbTable();
        $primaries = $table->info(Zend_Db_Table::PRIMARY);
        $search    = array();
        foreach ($primaries as $primary) {
            $content = $this->_getParam($primary, null);
            if ($content === null) {
                throw new Hazel_Controller_Exception('Invalid Primary Key');
            }
            $search[$primary] = $content;
        }
        $form      = $this->getForm();
        $form->populate($search);
        foreach ($search as $identifier => $value) {
            $search[$identifier] = $form->getValue($identifier);
        }
        $element = $table->find($search)->current();
        if ($element === null) {
            throw new Hazel_Controller_Exception('Invalid Element');
        }
        return $element;
    }

    /**
     * Criação de Objeto de Formulário
     * @return Zend_Form
     */
    public function getForm()
    {
        if ($this->_form == null) {
            $this->_form = $this->_getPackageElement('Form');
        }
        $name    = $this->_form;
        $element = new $name();
        return $element;
    }

    /**
     * Retorno de Posições de Colunas
     * @return array
     */
    public function getColumns()
    {
        $columns = $this->_columns;
        if (!is_array($columns)) {
            $columns = (array) $columns;
        }
        if (empty($columns)) {
            $table  = $this->getDbTable();
            $search = $table->info(Zend_Db_Table::COLS);
            foreach ($search as $position) {
                $columns[$position] = $position;
            }
        }
        $this->_columns = $columns;
        return $this->_columns;
    }

    /**
     * Confirmação de Exceções Configuradas no Aplicativo
     * @return boolean Confirmação
     */
    public function getDisplayExceptions()
    {
        return (boolean) $this->getInvokeArg('displayExceptions');
    }

    /**
     * Ação Principal da Controladora
     * @return void
     */
    public function indexAction()
    {
        $this->_helper->redirector('retrieve');
    }

    /**
     * Ação Criadora de Elementos para Banco de Dados
     * @return void
     */
    public function createAction()
    {
        $form = $this->getForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data    = $form->getValues();
                $table   = $this->getDbTable();
                $element = $table->createRow($data);
                try {
                    $element->save();
                    $this->view->message = self::MESSAGE_CREATE_SUCCESS;
                    $this->_forward('retrieve');
                } catch (Zend_Db_Exception $e) {
                    if ($this->getDisplayExceptions()) {
                        throw $e;
                    }
                    $form->addError($e->getCode());
                }
            }
        }
        $this->view->form = $form;
    }

    /**
     * Ação de Pesquisa de Elementos do Banco de Dados
     * @return void
     */
    public function retrieveAction()
    {
        $table   = $this->getDbTable();
        $select  = $this->_getRetrieveSelect();
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);

        $paginator = new Zend_Paginator($adapter);
        $page = $this->_getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        $this->view->result    = $paginator;
        $this->view->columns   = $this->getColumns();
        $this->view->primaries = $table->info(Zend_Db_Table::PRIMARY);
    }

    /**
     * Atualização de Informações no Banco de Dados
     * @return void
     */
    public function updateAction()
    {
        $element = $this->getElement();
        $form    = $this->getForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();
                $element->setFromArray($data);
                try {
                    $element->save();
                    $this->view->message = self::MESSAGE_UPDATE_SUCCESS;
                    $this->_forward('retrieve');
                } catch (Zend_Db_Exception $e) {
                    if ($this->getDisplayExceptions()) {
                        throw $e;
                    }
                    $form->addError($e->getCode());
                }
            }
        }
        $form->populate($element->toArray());
        $this->view->form = $form;
    }

    /**
     * Remove Informações de Elementos do Banco de Dados
     * @return void
     */
    public function deleteAction()
    {
        $element = $this->getElement();
        try {
            $element->delete();
            $this->view->message = self::MESSAGE_DELETE_SUCCESS;
            $this->_forward('retrieve');
        } catch (Zend_Db_Exception $e) {
            if ($this->getDisplayExceptions()) {
                throw $e;
            }
            $this->view->message = self::MESSAGE_DELETE_ERROR;
        }
        $this->_forward('retrieve');
    }
}