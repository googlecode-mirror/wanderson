<?php
/**
 * Hazel Zend Framework Extended Library
 * 
 * LICENSE
 * 
 * Copyright (c) 2010, Wanderson Henrique Camargo Rosa.
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permited provided that the following conditions are met:
 * 
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 * 
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 * 
 *     * Neither the name of the author nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * Zend Framework
 * Copyright (c) Zend Technologies Ltd. All rights reserved.
 * 
 * @category Hazel
 * @package  Hazel_Bibliography
 * @author   Wanderson Henrique Camargo Rosa
 * @link     http://code.google.com/p/wanderson/wiki/Hazel_Bibliography
 */

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