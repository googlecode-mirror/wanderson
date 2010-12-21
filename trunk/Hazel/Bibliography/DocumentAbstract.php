<?php

/**
 * Hazel Bibliography Document
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Document
 */
abstract class Hazel_Bibliography_DocumentAbstract
{
    /**
     * Nome Identificador do Documento
     * 
     * @var string
     */
    protected $_name;

    /**
     * Configuração do Nome Identificador do Documento
     * 
     * @param string $name
     * @return Hazel_Bibliography_DocumentAbstract Próprio Objeto
     */
    public final function setName($name)
    {
        $name = (string) $name;
        $this->_name = $name;
        return $this;
    }

    /**
     * Informação do Nome Identificador do Documento
     * 
     * @return string Nome Identificador para Gerenciamento
     */
    public final function getName()
    {
        return $this->_name;
    }
}