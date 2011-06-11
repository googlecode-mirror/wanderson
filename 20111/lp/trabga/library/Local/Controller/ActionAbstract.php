<?php

/**
 * Controladora de Ações Abstrata
 * 
 * Auxilia a utilização de controladoras que possuem formulários e tabelas de
 * banco de dados específicas, necessitando sempre ser inicializadas.
 * 
 * @category   Local
 * @package    Local_Controller
 * @subpackage Action
 */
abstract class Local_Controller_ActionAbstract
    extends Zend_Controller_Action
{
    /**
     * Nome da Classe de Tabela Padrão do Banco de Dados
     * @var string
     */
    protected $_dbTableClass = null;

    /**
     * Nome da Classe de Formulários Padrão
     * @var string
     */
    protected $_formClass = null;

    /**
     * Tabela de Banco de Dados Padrão da Controladora
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable = null;

    /**
     * Formulário Padrão da Controladora
     * @var Zend_Form
     */
    protected $_form = null;

    /**
     * Construção de Objetos para Elementos Internas
     * @param string $name Nome Completo da Classe
     * @return mixed Instância da Classe Solicitada
     * @throws Zend_Controller_Action_Exception Classe Inválida
     */
    private function _build($name, array $params = array())
    {
        if (!(is_string($name) && class_exists($name))) {
            throw new Zend_Controller_Action_Exception('Invalid Class Name');
        }
        // Construção
        $reflect = new Zend_Reflection_Class($name);
        // Retorno da Instância
        return $reflect->newInstance($params);
    }

    /**
     * Informação da Tabela de Banco de Dados Padrão da Controladora
     * @return Zend_Db_Table_Abstract Elemento Solicitado
     */
    protected function _getDbTable()
    {
        if ($this->_dbTable === null) {
            $this->_dbTable = $this->_build($this->_dbTableClass);
        }
        return $this->_dbTable;
    }

    /**
     * Informação do Formulário Padrão da Controladora
     * @return Zend_Form Elemento Solicitado
     */
    protected function _getForm()
    {
        if ($this->_form === null) {
            $this->_form = $this->_build($this->_formClass);
        }
        return $this->_form;
    }

    /**
     * Captura de Chaves Primárias
     * @return array Elementos Solicitados
     */
    protected function _getPrimaries($closure = null)
    {
        $primaries = $this->_getDbTable()->info(Zend_Db_Table::PRIMARY);
        $mapper    = array();
        foreach ($primaries as $name) {
            $value = $this->_getParam($name);
            $mapper[$name] = isset($closure) ? $closure($value) : $value;
        }
        return $mapper;
    }
}