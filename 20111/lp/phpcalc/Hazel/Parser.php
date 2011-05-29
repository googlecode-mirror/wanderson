<?php

namespace Hazel;

use Hazel\Parser\Lexer;

/**
 * Analisador Sintático
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel\Parser
 */
abstract class Parser
{
    /**
     * Analisador Léxico
     * @var Lexer
     */
    protected $_lexer;

    /**
     * Construtor
     * @param Analisador Léxico $lexer
     */
    public function __construct(Lexer $lexer)
    {
        $this->setLexer($lexer);
    }

    /**
     * Configura o Analisador Léxico
     * @param Lexer $lexer Elemento para Configuração
     * @return Parser Próprio Objeto para Encadeamento
     */
    public function setLexer(Lexer $lexer)
    {
        $this->_lexer = $lexer;
        return $this;
    }

    /**
     * Informa o Analisador Léxico
     * @return Lexer Elemento Solicitado
     */
    public function getLexer()
    {
        return $this->_lexer;
    }

    /**
     * Tradução da Entrada
     * @param string $input Conteúdo da Entrada
     * @return mixed Saída Esperada
     */
    public function parse($input)
    {
        /* Analisador Léxico */
        $lexer = $this->getLexer();
        $lexer->clear()->read($input);
        /* Analisador Sintático */
        return $this->execute();
    }

    /**
     * Execução do Tradutor Após Lista de Tokens
     * @return mixed Saída Esperada
     */
    abstract public function execute();
}