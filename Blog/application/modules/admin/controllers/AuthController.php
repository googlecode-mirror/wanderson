<?php

class Admin_AuthController extends Zend_Controller_Action
{
    public function loginAction()
    {
        $form = new Admin_Form_Auth();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();

                $table = new Admin_Model_DbTable_User();

                $adapter = new Zend_Auth_Adapter_DbTable();
                $adapter
                    ->setTableName($table->info(Zend_Db_Table::NAME))
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password')
                    ->getDbSelect()
                        ->where('active = TRUE')
                        ->where('deleted = FALSE');

                $adapter
                    ->setIdentity($data['username'])
                    ->setCredential($data['password']);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);
                if ($result->isValid()) {
                    $contents = $adapter->getResultRowObject(null, 'password');
                    $auth->getStorage()->write($contents);
                    $this->_helper->redirector('index','index');
                } else {
                    $form->getElement('username')
                        ->addError('Erro ao Autenticar no Servidor');
                }
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector('login');
    }
}