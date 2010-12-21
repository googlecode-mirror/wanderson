<?php

/**
 * Hazel Bibliography Manager
 * 
 * @category Hazel
 * @package  Hazel_Bibliography
 * @author   Wanderson Henrique Camargo Rosa
 */
class Hazel_Bibliography_Manager
{
    /**
     * Formatador do Gerenciamento
     * 
     * @var Hazel_Bibliography_FormatterAbstract
     */
    protected $_formatter;

    /**
     * Documentos do Gerenciamento
     * 
     * @var array
     */
    protected $_documents = array();

    /**
     * Configuração do Formatador do Gerenciamento
     * 
     * @param Hazel_Bibliography_FormatterAbstract $formatter
     * @return Hazel_Bibliography_Manager Próprio Objeto
     */
    public function setFormatter(Hazel_Bibliography_FormatterAbstract $formatter)
    {
        $this->_formatter = $formatter;
        return $this;
    }

    /**
     * Informação do Formatador do Gerenciamento
     * 
     * @return Hazel_Bibliography_FormatterAbstract Formatador do Gerenciamento
     */
    public function getFormatter()
    {
        return $this->_formatter;
    }

    /**
     * Adiciona um Documento no Gerenciamento
     * 
     * @param string $name Nome Identificador do Documento
     * @param Hazel_Bibliography_DocumentAbstract $document
     * @return Hazel_Bibliography_Manager Próprio Objeto
     */
    public function addFormatter($name, Hazel_Bibliography_DocumentAbstract $document)
    {
        $name = (string) $name;
        $this->documents[$name] = $document;
        return $this;
    }

    /**
     * Informa um Documento no Gerenciamento
     * 
     * @param string $name Nome Identificador do Documento
     * @return Hazel_Bibliography_DocumentAbstract|null Documento no Gerenciamento
     */
    public function getFormatter($name)
    {
        $name = (string) $name;
        $document = null;
        if (isset($this->documents[$name])) {
            $document = $this->documents[$name];
        }
        return $this;
    }

    /**
     * Remove um Documento no Gerenciamento
     * 
     * @param string $name
     * @return Hazel_Bibliography_Manager Próprio Objeto
     */
    public function removeFormatter($name)
    {
        $name = (string) $name;
        unset($this->documents[$name]);
        return $this;
    }

    /**
     * Informa o Conjunto de Documentos do Gerenciamento
     * 
     * @return array Lista de Documentos
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Renderização de Documentos pelo Formatador
     * 
     * @return string Referências Bibliográficas Formatadas
     */
    public function render()
    {
        $formatter = $this->getFormatter();
        $documents = $this->getDocuments();

        $content = array();
        foreach ($documents as $document) {
            $content[] = $formatter->format($document);
        }
        $content = implode(' ', $content);

        return $content;
    }

    /**
     * Renderização de Documentos pelo Formatador
     * 
     * @return string Referências Bibliográficas Formatadas
     */
    public function __toString()
    {
        return $this->render();
    }
}