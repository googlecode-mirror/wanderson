#ifndef AST_TREE
#define AST_TREE
#include "node.h"

namespace AST {

    /**
     * Árvore de Sintaxe
     *
     * Estrutura utilizada para criação de uma árvore abstrata de sintaxe que
     * possibilita a construção e relacionamento de nós que possuem
     * relacionamento dentro e uma linguagem de programação. Iniciando pela sua
     * raiz, podemos criar a estrutura utilizando os relacionamentos de nós.
     * Para exibição, existe um método especializado que busca construir uma
     * saída em formato apropriado.
     *
     * @category AST
     * @package  AST
     */
    class Tree {

    private:

        /**
         * Nó Raiz da Árvore
         */
        Node* _root;

        /**
         * Configuração do Nó Raiz
         * @param  Node* Elemento para Configuração
         * @return Próprio Objeto para Encadeamento
         */
        Tree* _setRoot(Node*);

    public:

        /**
         * Construtor Padrão
         * @param Node* Nó Raiz Base da Árvore
         */
        Tree(Node*);

        /**
         * Captura do Nó Raiz
         * @return Elemento Solicitado
         */
        Node* getRoot();

        /**
         * Conversão para String
         * @return Saída em Formato Apropriado para Visualização
         */
        std::string toString();

    };

};

#endif

