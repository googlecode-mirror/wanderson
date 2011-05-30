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
        '=' => 0,
        '+' => 1, '-' => 1,
        '*' => 2, '/' => 2,
        '^' => 3, '#' => 3,
    );

    /**
     * Variáveis Configuradas
     * @var array
     */
    protected $_variables = array();

    /**
     * Definições de Comandos
     * @var array
     */
    protected $_definitions = array();

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
        /* @todo Checar Precedência */
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
            if ($token->isA('T_NUMBER') || $token->isA('T_FLOAT') || $token->isA('T_VAR')) {
                $postfix[] = $token;
            } elseif ($token->isA('T_OPERATOR') || $token->isA('T_ASSIGN')) {
                /* @todo Melhorar Pesquisa */
                $found = false;
                while (!$found) {
                    if ($stack->isEmpty()) {
                        $stack->push($token);
                        $found = true;
                    } else {
                        if ($stack->top()->isA('T_OB')) {
                            $stack->push($token);
                            $found = true;
                        } elseif ($this->precedence($token, $stack->top()) > 0) {
                            $stack->push($token);
                            $found = true;
                        } else {
                            $postfix[] = $stack->pop();
                        }
                    }
                }
            } elseif ($token->isA('T_OB')) {
                $stack->push($token);
            } elseif ($token->isA('T_CB')) {
                while (!$stack->isEmpty() && !$stack->top()->isA('T_OB')) {
                    $postfix[] = $stack->pop();
                }
                $stack->pop();
            } else {
                $format  = "Invalid Token '%s' @column %d";
                $message = sprintf($format, $token->getType(), $token->getPosition());
                throw new Exception($message);
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
            } elseif ($token->isA('T_ASSIGN')) {
                $valueB = $stack->pop();
                $valueA = $stack->pop();
                $this->setValue($valueA, $valueB);
                $stack->push($valueB);
            } else {
                $stack->push($token->getContent());
            }
        }
        /* @todo Verificar Filtro */
        $result = $this->_filter($stack->pop());
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
        /* Filtro de Valores */
        $valueA = $this->_filter($valueA);
        $valueB = $this->_filter($valueB);
        /* @todo Verificar Filtro */

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

    /**
     * Filtro de Valores Conforme Necessidade
     * Pode buscar informações na tabela de variáveis caso valor seja String
     * @param mixed $value Valor para Filtragem
     * @return mixed Valor Filtrado
     */
    public function _filter($value)
    {
        /* @todo Melhorias em Filtragem */
        if (is_string($value) && preg_match('/^\\$/', $value)) {
            $value = $this->getValue($value);
        }
        return $value;
    }

    /**
     * Informa o Valor de Variáveis
     * @param string $name Nome da Variável
     * @return mixed Valor Solicitado
     */
    public function getValue($name)
    {
        /* @todo Verificar Existência de Variável */
        return $this->_variables[$name];
    }

    /**
     * Configura o Valor de Variável
     * @param string $name Nome da Variável
     * @param mixed $value Valor para Configuração
     * @return Parser Próprio Objeto para Encadeamento
     */
    public function setValue($name, $value)
    {
        $this->_variables[$name] = $value;
        return $this;
    }

    /**
     * Informa o Bloco de Comando para Definição
     * @param string $name Nome da Definição
     * @return mixed Valor Solicitado
     */
    public function getDefinition($name)
    {
        /* @todo Verificar Existência de Definição */
        return $this->_definitions[$name];
    }

    /**
     * Configura um Bloco de Comando
     * @param string $name Nome da Definição
     * @param mixed $block Bloco para Configuração
     * @return Parser Próprio Objeto para Encadeamento
     */
    public function setDefinition($name, $block)
    {
        $this->_definitions[$name] = $block;
        return $this;
    }
}