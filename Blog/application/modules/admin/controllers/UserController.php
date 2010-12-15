<?php

/**
 * Controladora de Usuários
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Admin
 * @package  Admin_Controller
 */
class Admin_UserController extends Zend_Controller_Action
{
    /**
     * Ação Padrão da Controladora
     * 
     * @return void
     */
    public function indexAction()
    {
        $this->_helper->redirector('retrieve');
    }

    /**
     * Listagem de Usuários
     * 
     * @return void
     */
    public function retrieveAction()
    {
        $table = new Admin_Model_DbTable_User();
        $select = $table->select();
        $select->order('username');
        $result = $table->fetchAll($select);
        $this->view->result = $result;
    }

    /**
     * Criação de Novo Usuário
     * 
     * @return void
     */
    public function createAction()
    {
        $form = new Admin_Form_User();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();
                $table = new Admin_Model_DbTable_User();
                $element = $table->createRow($data);
                try {
                    $element->save();
                    $this->_helper->redirector('retrieve');
                } catch (Zend_Db_Exception $e) {
                    $form->addError($e->getMessage());
                }
            }
        }
        $this->view->form = $form;
    }

    /**
     * Atualização de Usuário
     * 
     * @return void
     */
    public function updateAction()
    {
        $iduser = (int) $this->_getParam('iduser', 0);
        $table = new Admin_Model_DbTable_User();
        $element = $table->find($iduser)->current();
        if ($element === null) {
            throw new Zend_Exception('Invalid Element');
        }
        $form = new Admin_Form_User();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $data = $form->getValues();
                $element->setFromArray($data);
                try {
                    $element->save();
                    $this->_helper->redirector('retrieve');
                } catch (Zend_Db_Exception $e) {
                    $form->addError($e->getMessage());
                }
            }
        } else {
            $form->populate($element->toArray());
        }
        $this->view->form = $form;
    }

    /**
     * Remove um Usuário
     * 
     * @return void
     */
    public function deleteAction()
    {
        $iduser = (int) $this->_getParam('iduser', 0);
        $table = new Admin_Model_DbTable_User();
        $element = $table->find($iduser)->current();
        if ($element === null) {
            throw new Zend_Exception('Invalid Element');
        }
        $element->delete();
        $this->_helper->redirector('retrieve');
    }

    /**
     * Atualização da Senha do Usuário
     * 
     * @return void
     */
    public function passwordAction()
    {
        $iduser = (int) $this->_getParam('iduser', 0);
        $table = new Admin_Model_DbTable_User();
        $element = $table->find($iduser)->current();
        if ($element === null) {
            throw new Zend_Exception('Invalid Element');
        }
        $form = new Admin_Form_Password();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $repeat = $form->getValue('repeat');
                $element->password = $repeat;
                try {
                    $element->save();
                    $this->_helper->redirector('retrieve');
                } catch (Zend_Db_Exception $e) {
                    $form->addError($e->getMessage());
                }
            }
        } else {
            $form->populate($element->toArray());
        }
        $this->view->form = $form;
        $this->view->element = $element;
    }
}