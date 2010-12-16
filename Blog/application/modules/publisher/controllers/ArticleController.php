<?php

/**
 * Controladora de Artigos
 * 
 * Mantenedora de Artigos da Publicadora. Trabalha com um padrão CRUD e tenta
 * manter o mesmo padrão das outras controladoras. Encapsulamento de algumas
 * ações semelhantes entre as ações.
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_Article
 * @subpackage Controller
 */
class Publisher_ArticleController extends Zend_Controller_Action
{
    /**
     * Solicita um Artigo a partir de variáveis da requisição
     * 
     * @return Publisher_Model_DbTable_Row_Article Artigo Encontrado
     * @throws Zend_Db_Exception Elemento Inválido
     */
    protected function _getElement()
    {
        $idarticle = $this->_getParam('idarticle', 0);
        $table = new Publisher_Model_DbTable_Article();
        $element = $table->find($idarticle)->current();
        if ($element === null) {
            throw new Zend_Db_Exception('Invalid Element');
        }
        return $element;
    }

    /**
     * Ação de Criação de Artigos
     * 
     * @return void
     */
    public function createAction()
    {
        $form = new Publisher_Form_Article();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $table = new Publisher_Model_DbTable_Article();
                $element = $table->createRow();
                $element->setFromForm($form);
                $element->save();
            }
        }
        $this->view->form = $form;
    }

    /**
     * Atualização de Artigo
     * 
     * @return void
     */
    public function updateAction()
    {
        $element = $this->_getElement();
        $form = new Publisher_Form_Article();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form->isValid($data)) {
                $element->setFromForm($form);
                $element->save();
            }
        } else {
            $form->populate($element->toArray());
        }
        $this->view->form = $form;
    }

    /**
     * Visualização de Artigo
     * 
     * @return void
     */
    public function viewAction()
    {
        $element  = $this->_getElement();
        $author   = $element->findParentAuthor();
        $category = $element->findParentCategory();

        $renderer = Zend_Markup::factory('Textile');
        $content  = $renderer->render($element->content);

        $this->view->content     = $content;
        $this->view->title       = $element->title;
        $this->view->author      = $author->displayname;
        $this->view->created     = $element->created;
        $this->view->abstract    = $element->abstract;
        $this->view->description = $element->description;
        $this->view->category    = $category !== null ? $category->name : null;
    }
}