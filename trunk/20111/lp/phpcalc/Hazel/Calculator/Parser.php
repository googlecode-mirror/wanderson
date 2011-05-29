<?php

namespace Hazel\Calculator;

use Hazel\Parser\Exception;
use Hazel\Parser as ParserAbstract;

/**
 * Tradução da Entrada
 *
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel\Parser
 */
class Parser extends ParserAbstract
{
    /**
     * Mapeamento de Precedências
     * @var array
     */
    protected $_mapper = array(
        '+' => 1, '-' => 1,
        '*' => 2, '/' => 2,
        '^' => 3, '#' => 3,
    );

    /**
     * Construtor
     * Utiliza o Analisador Léxico do Pacote
     */
    public function __construct()
    {
        $lexer = new Lexer();
        parent::__construct($lexer);
    }

    /**
     * Verificação da Precedência
     * @param Token $tokenA Token para Verificação
     * @param Token $tokenB Token para Verificação
     * @throws Exception Token de Tipo Não Operador
     * @return int Comparação de Precedências dos Tokens
     */
    public function precedence($tokenA, $tokenB)
    {
        if (!($tokenA->isA('T_OPERATOR') && $tokenB->isA('T_OPERATOR'))) {
            throw new Exception('Token must be an Operator');
        }
        $precedenceA = $this->_mapper[$tokenA->getContent()];
        $precedenceB = $this->_mapper[$tokenB->getContent()];
        return $precedenceA - $precedenceB;
    }

    /**
     * Conversão de Formato Infixo para Posfixo
     * @return array Fila de Tokens para Cálculo Posfixo
     */
    public function toPostfix()
    {
        /* Analisador Léxico */
        $lexer = $this->getLexer();
        /* Pilha para Conversão */
        $stack = new \SplStack();
        /* Notação Polonesa Reversa */
        $postfix = array();
        /* Execução */
        while (($token = $lexer->getToken()) != null) {
            /* Analisador Sintático */
            if ($token->isA('T_NUMBER')) {
                $postfix[] = $token;
            } elseif ($token->isA('T_OPERATOR')) {
                /* @todo Melhorar Pesquisa */
                $found = false;
                while (!$found) {
                    if ($stack->isEmpty()) {
                        $stack->push($token);
                        $found = true;
                    } else {
                        if ($this->precedence($token, $stack->top()) > 0) {
                            $stack->push($token);
                            $found = true;
                        } else {
                            $postfix[] = $stack->pop();
                        }
                    }
                }
            } else {
                /* @todo Verificar Tipo de Token */
            }
        }
        /* Tokens Restantes na Pilha */
        while (!$stack->isEmpty()) {
            $postfix[] = $stack->pop();
        }
        return $postfix;
    }

    public function execute()
    {
        /* Conversão para Posfixo */
        $postfix = $this->toPostfix();
        /* Cálculo */
        $result = $this->_calc($postfix);
        /* Envio do Resultado */
        return $result;
    }

    /**
     * Calcula o Resultado da Expressão Posfixa
     * @param array $input Tokens de Entrada
     * @return mixed Resultado do Cálculo da Expressão
     */
    protected function _calc(array $input)
    {
        $stack = new \SplStack();
        foreach ($input as $token) {
            if ($token->isA('T_OPERATOR')) {
                $valueB = $stack->pop();
                $valueA = $stack->pop();
                $result = $this->_operate($token->getContent(), $valueA, $valueB);
                $stack->push($result);
            } else {
                $stack->push($token->getContent());
            }
        }
        $result = $stack->pop();
        /* @todo Verificar Pilha Não Vazia */
        return $result;
    }

    /**
     * Encapsulamento de Operações
     * @param mixed $operator Operador para Execução
     * @param mixed $valueA   Primeiro Valor de Entrada
     * @param mixed $valueB   Segundo Valor de Entrada
     * @return mixed Resultado da Operação
     */
    protected function _operate($operator, $valueA, $valueB = null)
    {
        $result = 0;
        switch ($operator) {
        case '+':
            $result = $valueA + $valueB;
            break;
        case '-':
            $result = $valueA - $valueB;
            break;
        case '*':
            $result = $valueA * $valueB;
            break;
        case '/':
            $result = $valueA / $valueB;
            break;
        case '^':
            $result = pow($valueA, $valueB);
            break;
        case '#':
            $result = pow($valueA, 1/$valueB);
            break;
        }
        /* @todo Verificar Operador Inválido */
        return $result;
    }
}