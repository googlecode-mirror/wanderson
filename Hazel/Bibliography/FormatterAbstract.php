<?php

/**
 * Hazel Bibliography Formatter
 * 
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Formatter
 * @author     Wanderson Henrique Camargo Rosa
 */
abstract class Hazel_Bibliography_FormatterAbstract
{
    /**
     * Formatação da Referência Bibliográfica
     * 
     * @param Hazel_Bibliography_DocumentAbstract $document
     * @return string Referência Formatada
     */
    public function format(Hazel_Bibliography_DocumentAbstract $document)
    {
        $type = array_pop(explode('_', get_class($document)));
        $method = "format{$type}";
        $result = (string) $this->$method($document);
        return $result;
    }

    /**
     * Método Mágico para Tratamento de Chamadas Inválidas
     * 
     * @param string $name Nome do Método
     * @param array $args Argumentos da Chamada
     * @return Hazel_Bibliography_FormatterAbstract Próprio Objetos
     */
    public function __call($name, $args)
    {
        if (preg_match('/^format([a-zA-Z]+)$/', $name, $match)) {
            throw new Hazel_Bibliography_Exception("Invalid Formatter: '{$match[1]}'");
        } else {
            throw new Hazel_Bibliography_Exception("Invalid Method: '$name'");
        }
        return $this;
    }
}