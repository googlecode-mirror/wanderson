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
