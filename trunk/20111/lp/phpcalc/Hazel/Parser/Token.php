<?php

namespace Hazel\Parser;

/**
 * Token
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel\Parser
 */
class Token
{
    /**
     * Tipo do Token
     * @var string
     */
    protected $_type;

    /**
     * Conteúdo Capturado
     * @var string
     */
    protected $_content;

    /**
     * Posição do Elemento na Entrada
     * @var int
     */
    protected $_position;

    /**
     * Construtor
     * @param string $type Tipo do Token
     * @param string $content Conteúdo Capturado
     */
    public function __construct($type, $content = null)
    {
        $this->setType($type)->setContent($content);
    }

    /**
     * Configura o Tipo do Token
     * @param string $type Valor para Configuração
     * @return Token Próprio Elemento para Encadeamento
     */
    public function setType($type)
    {
        $this->_type = (string) $type;
        return $this;
    }

    /**
     * Informa o Tipo do Token
     * @return string Valor Solicitado
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Configura o Conteúdo Capturado
     * @param string $content Valor para Configuração
     * @return Token Próprio Objeto para Encadeamento
     */
    public function setContent($content)
    {
        $this->_content = (string) $content;
        return $this;
    }

    /**
     * Informa o Conteúdo Capturado
     * @return string Valor Solicitado
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Configura a Posição do Elemento na Entrada
     * @param int $position Valor para Configuração
     * @return Token Próprio Objeto para Encadeamento
     */
    public function setPosition($position)
    {
        $this->_position = (int) $position;
        return $this;
    }

    /**
     * Informa a Posição do Elemento na Entrada
     * @return int Valor Solicitado
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * Verificação de Tipagem do Token
     * @param string $type Tipo para Verificação
     * @return boolean Resultado da Comparação de Tipos
     */
    public function isA($type)
    {
        return $this->getType() === $type;
    }
}