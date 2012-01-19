<?php

/**
 * Controladora de Funções
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category Acl
 * @package  Acl_Controller
 */
class Acl_RolesController extends Zend_Controller_Action
{
    /**
     * Ação Principal de Listagem
     * @return null
     */
    public function indexAction()
    {
        // Inicialização
        $mapper = new Acl_Model_Mapper_Roles();
        // Busca de Informações
        $elements = $mapper->fetch();
        // Camada de Visualização
        $this->view->elements = $elements;
    }
}
