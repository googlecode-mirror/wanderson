#ifndef AST_OPERATOR
#define AST_OPERATOR
#include "node.h"

namespace AST {

    /**
     * Operador Binário
     *
     * Elemento que recebe dois operandos e fornece como resultado algum
     * processamento sobre estes elementos apresentados.
     *
     * @category AST
     * @package  AST
     */
    class Operator : public Node {

    private:

        /**
         * Expressão à Esquerda
         */
        Node* _left;

        /**
         * Expressão à Direita
         */
        Node* _right;

        /**
         * Configuração de Expressão à Esquerda
         * @param  Node* Elemento para Configuração
         * @return Próprio Objeto para Encadeamento
         */
        Operator* _setLeft(Node*);

        /**
         * Configuração de Expressão à Direita
         * @param  Node* Elemento para Configuração
         * @return Próprio Objeto para Encadeamento
         */
        Operator* _setRight(Node*);

    public:

        /**
         * Construtor
         * @param int Número do Token Utilizado
         * @param std::string Conteúdo Capturado pelo Token
         * @param Node* Elemento Esquerdo para Configuração
         * @param Node* Elemento Direito para Configuração
         */
        Operator(int, std::string, Node*, Node*);

        // Sobrescrita
        std::string toString(int);

        /**
         * Captura de Expressão à Esquerda
         * @return Elemento Configurado
         */
        Node* getLeft();

        /**
         * Captura de Expressão à Direita
         * @return Elemento Configurado
         */
        Node* getRight();

    };

};

#endif

