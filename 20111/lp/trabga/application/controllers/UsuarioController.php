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
     * @return null
     */
    public function indexAction()
    {
        // Banco de Dados
        $table  = $this->_getDbTable();
        $select = $table->select()->order('idusuario ASC');
        $result = $table->fetchAll($select);

        // Mensagens
        $messages = $this->_helper->flashMessenger->getMessages();

        // Camada de Visualização
        $this->view->result = $result;
        $this->view->messages = $messages;
    }

    /**
     * Edit Action
     * @return null
     */
    public function editAction()
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

        // Autor
        $autor = $element->findParentRow('Autor');
        $instituicao = $autor->findParentRow('Instituicao');

        // Formulário
        $form = $this->_getForm();

        if ($this->getRequest()->isPost()) {
            // Envio de Dados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Adaptador do Banco
                $adapter = $element->getTable()->getAdapter();

                // Início da Manipulação
                $adapter->beginTransaction();

                try {

                    // Usuário
                    $element->ativado    = (int) $data['ativado'];
                    $element->identidade = $data['info']['identidade'];
                    if ($data['info']['credencial'] != null) {
                        $element->credencial = md5($data['info']['credencial']);
                    }
                    $element->save();

                    // Autor
                    $autor->nome  = $data['info']['autor']['nome'];
                    $autor->email = $data['info']['autor']['email'];
                    $autor->save();

                    // Instituicao
                    $instituicao->endereco =
                        $data['info']['autor']['instituicao']['endereco'];
                    $instituicao->save();

                    $element->getTable()->getAdapter()->commit();

                } catch (Zend_Db_Exception $e) {
                    $element->getTable()->getAdapter()->rollBack();
                    throw $e;
                }

                $this->_helper->flashMessenger('update');
                $this->_helper->redirector('index');

            }
        } else {
            // População
            $form->info->identidade->setValue($element->identidade);
            $form->info->autor->nome->setValue($autor->nome);
            $form->info->autor->email->setValue($autor->email);
            $form->info->autor->instituicao->endereco
                ->setValue($instituicao->endereco);
            $form->ativado->setValue($element->ativado);
        }

        // Limpeza do Campo de Senha
        $form->getSubForm('info')->getElement('credencial')->setValue('');

        $this->view->form = $form;
        $this->view->element = $element;
    }

    /**
     * Remove Action
     * @return null
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

        // Remoção do Elemento no Banco
        $element->delete();

        // Mensagens
        $this->_helper->flashMessenger('delete');
        $this->_helper->redirector('index');
    }

    /**
     * Index Action
     */
    public function infoAction()
    {
        // Formulário
        $form = new Application_Form_UsuarioInfo();

        // Identificador do Usuário
        $auth = Zend_Auth::getInstance();
        $idusuario = $auth->getIdentity()->idusuario;

        // Pesquisa do Usuário
        $table   = $this->_getDbTable();
        $element = $table->find($idusuario)->current();

        // Elemento não Encontrado
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }

        // Ignorar Nome de Usuário
        $form->identidade->setIgnore(true);

        // Valores para Preenchimento
        $autor = $element->findParentRow('Autor');
        $instituicao = $autor->findParentRow('Instituicao');

        if ($this->getRequest()->isPost()) {
            // Dados Enviados
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                // Banco de Dados
                $table->getAdapter()->beginTransaction();
                try {

                    // Usuário
                    if ($data['credencial'] !== null) {
                        $credencial = md5($data['credencial']);
                        $element->credencial = $credencial;
                        $element->save();
                    }

                    // Autor
                    $autor->nome  = $data['autor']['nome'];
                    $autor->email = $data['autor']['email'];
                    $autor->save();

                    // Endereço
                    $instituicao->endereco = $data['autor']['instituicao']['endereco'];
                    $instituicao->save();

                    $table->getAdapter()->commit();

                } catch (Zend_Db_Exception $e) {
                    $table->getAdapter()->rollBack();
                    throw $e;
                }

                $this->_helper->flashMessenger('success');
                $this->_helper->redirector('info');

            }
        } else {

            // População
            $form->autor->nome->setValue($autor->nome);
            $form->autor->email->setValue($autor->email);
            $form->autor->instituicao->endereco->setValue($instituicao->endereco);

        }

        // População Padrão
        $form->identidade->setValue($element->identidade);
        $form->credencial->setValue(null);

        // Nome do Usuário é Preenchido e Desabilitado
        $form->identidade->setAttrib('disabled', true);

        // Camada de Visualização
        $this->view->form = $form;
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }
}
