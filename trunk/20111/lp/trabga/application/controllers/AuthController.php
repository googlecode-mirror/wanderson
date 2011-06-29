<?php

/**
 * Authentication Controller
 * 
 * @category Application
 * @package  Application_Controller
 *
 */
class AuthController extends Local_Controller_ActionAbstract
{
    /**
     * Classe de Formulário
     * @var string
     */
    protected $_formClass = 'Application_Form_Auth';

    /**
     * Login Action
     * @return null
     */
    public function loginAction()
    {
        // Formulário
        $form = $this->_getForm();

        // Verificação
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();
                // Tentativa de Login
                $username = $data['identidade'];
                $password = $data['credencial'];
                $adapter  = $this->_getAdapter($username, $password);
                // Autenticação
                $auth   = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);
                // Verificação do Resultado
                if ($result->isValid()) {
                    $contents = $this->_getData($adapter);
                    $auth->getStorage()->write($contents);
                    $this->_helper->redirector('index','index');
                } else {
                    $form->getElement('identidade')
                         ->addErrors($result->getMessages());
                }
            }
        }

        // Camada de Visualização
        $this->view->form = $form;
    }

    /**
     * Logout Action
     * @return null
     */
    public function logoutAction()
    {
        // Autenticador
        Zend_Auth::getInstance()->clearIdentity();
        // Redirecionamento
        $this->_helper->redirector('login');
    }

    /**
     * Informa o Adaptador Atual
     * @param string $username Nome do Usuário
     * @param string $password Senha
     * @return Zend_Auth_Adapter_Interface Adaptador de Conexão
     */
    protected function _getAdapter($username, $password)
    {
        // Conexão com Banco
        $table = new Application_Model_DbTable_Usuario();
        // Construção do Adaptador
        $adapter = new Zend_Auth_Adapter_DbTable($table->getAdapter());
        $adapter->setIdentityColumn('identidade')
                ->setCredentialColumn('credencial')
                ->setTableName($table->getTableName())
                ->setCredentialTreatment('MD5(?)');
        // Somente Usuários Ativos
        $adapter->getDbSelect()->where('ativado = ?', true);
        // Valores
        $adapter->setIdentity($username)
                ->setCredential($password);
        // Resultado da Construção
        return $adapter;
    }

    /**
     * Informa Dados Pertinentes ao Usuário
     * @param Zend_Auth_Adapter_Interface $adapter Adaptador da Conexão
     * @return array Dados Informados
     */
    protected function _getData(Zend_Auth_Adapter_Interface $adapter)
    {
        /* @var $adapter Zend_Auth_Adapter_DbTable */
        $data = $adapter->getResultRowObject(null, array('credencial'));
        return $data;
    }
}
