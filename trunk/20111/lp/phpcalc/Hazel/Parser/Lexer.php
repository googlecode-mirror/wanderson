<?php

namespace Hazel\Parser;

use Hazel\Parser\Token;
use Hazel\Parser\Exception;

/**
 * Analisador Léxico
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel\Parser
 */
abstract class Lexer
{
    /**
     * Lista de Tokens
     * @var array
     */
    protected $_tokenList = array();

    /**
     * Adiciona um Token na Lista
     * @param Token $token Elemento para Inclusão
     * @return Lexer Próprio Objeto para Encadeamento
     */
    public function addToken(Token $token)
    {
        $this->_tokenList[] = $token;
        return $this;
    }

    /**
     * Informa o Token Atual
     * @return Token Elemento Solicitado ou Nulo Conforme Ponteiro Interno
     */
    public function getToken()
    {
        list($position, $token) = each($this->_tokenList);
        return $token;
    }

    /**
     * Reinicialização do Ponteiro Interno
     * @return Lexer Próprio Objeto para Encadeamento
     */
    public function rewind()
    {
        reset($this->_tokenList);
        return $this;
    }

    /**
     * Limpa a Lista de Tokens
     * @return Lexer Próprio Objeto para Encadeamento
     */
    public function clear()
    {
        $this->_tokenList = array();
        return $this;
    }

    /**
     * Leitura e Análise Léxica da Entrada
     * @param string $input Conteúdo para Análise
     * @throws Exception Erro de Leitura
     * @return Lexer Próprio Objeto para Encadeamento
     */
    abstract public function read($input);
}