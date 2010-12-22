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
     * Expressão Regular para Captura de Documento
     * 
     * @var string
     */
    const PATTERN_DOCUMENT = '/^\s*@([a-z][a-zA-Z]*)\s*\{([a-zA-Z0-9]+),([^}]*)\}\s*$/';

    /**
     * Expressão Regular para Captura de Elementos de Documento
     */
    const PATTERN_ELEMENT = '/\s*([a-z][a-zA-Z]*)\s*=\s*"([^"]*)"\s*/';

    /**
     * Formatador do Gerenciamento
     * 
     * @var Hazel_Bibliography_FormatterAbstract
     */
    protected $_formatter;

    /**
     * Decorador da Bibliografia
     * 
     * @var Hazel_Bibliography_DecoratorAbstract
     */
    protected $_decorator;

    /**
     * Documentos do Gerenciamento
     * 
     * @var array
     */
    protected $_documents = array();

    /**
     * Construtor da Classe
     * 
     * @param array $options Configurações
     */
    public function __construct(array $options = array())
    {
        if (isset($options['formatter'])) {
            $this->setFormatter($options['formatter']);
        } else {
            $this->setFormatter(new Hazel_Bibliography_Formatter_Default());
        }

        if (isset($options['decorator'])) {
            $this->setDecorator($options['decorator']);
        } else {
            $this->setDecorator(new Hazel_Bibliography_Decorator_List());
        }
    }

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
     * Configuração do Decorador
     * 
     * @param Hazel_Bibliography_DecoratorAbstract $decorator
     * @return Hazel_Bibliography_Manager Próprio Objeto
     */
    public function setDecorator(Hazel_Bibliography_DecoratorAbstract $decorator)
    {
        $this->_decorator = $decorator;
        return $this;
    }

    /**
     * Informação do Decorador
     * 
     * @return Hazel_Bibliography_DecoratorAbstract Decorador da Bibliografia
     */
    public function getDecorator()
    {
        return $this->_decorator;
    }

    /**
     * Adiciona um Documento no Gerenciamento
     * 
     * @param string $name Nome Identificador do Documento
     * @param Hazel_Bibliography_DocumentAbstract $document
     * @return Hazel_Bibliography_Manager Próprio Objeto
     */
    public function addDocument(Hazel_Bibliography_DocumentAbstract $document)
    {
        $name = $document->getName();
        $this->documents[$name] = $document;
        return $this;
    }

    /**
     * Tradutor de Documentos Descritos BibTeX-like
     * 
     * @param string $content Conteúdo de Descrição
     * @return Hazel_Bibliography_Manager Próprio Objeto
     */
    public function parseDocument($content)
    {
        $document = self::factory($content);
        $this->addDocument($document);
        return $this;
    }

    /**
     * Informa um Documento no Gerenciamento
     * 
     * @param string $name Nome Identificador do Documento
     * @return Hazel_Bibliography_DocumentAbstract|null Documento no Gerenciamento
     */
    public function getDocument($name)
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
    public function removeDocument($name)
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

        $result = $this->getDecorator()->render($content);

        return $result;
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

    /**
     * Construtor de Documentos BibTeX-like
     * 
     * @param string $content Conteúdo para Análise Sintática
     * @return Hazel_Bibliography_DocumentAbstract Documento Resultante
     * @throws Hazel_Bibliography_Exception Formato Inválido de Conteúdo
     */
    public static function factory($content)
    {
        if (!preg_match(self::PATTERN_DOCUMENT, $content, $match)) {
            throw new Hazel_Bibliography_Exception('Invalid Bibliography Format');
        }

        $type = ucfirst($match[1]);
        $name = $match[2];

        $class = "Hazel_Bibliography_Document_$type";
        if (!class_exists($class)) {
            throw new Hazel_Bibliography_Exception("Invalid Bibliography Type: '$type'");
        }

        $document = new $class();
        $document->setName($name);
        $counter = preg_match_all(self::PATTERN_ELEMENT, $match[3], $match);

        for ($i = 0; $i < $counter; $i++) {

            $method = 'set' . ucfirst($match[1][$i]);
            $value  = $match[2][$i];

            if ($match[1][$i] == 'name' || !method_exists($document, $method)) {
                throw new Hazel_Bibliography_Exception("Invalid Bibliography Element: '{$match[1]}'");
            }

            $document->$method($value);

        }

        return $document;
    }
}