#include <string>
#include "operator.h"
namespace AST {

    // Construtor
    Operator::Operator(int token, std::string content, Node* left, Node* right)
        : Node::Node(token, content) {
            // Configuração Inicial
            this->_setLeft(left)->_setRight(right);
        };

    // Configuração de Expressão à Esquerda
    Operator* Operator::_setLeft(Node* left) {
        // Configuração
        this->left = left;
        // Encadeamento
        return this;
    };

    // Configuração de Expressão à Direita
    Operator* Operator::_setRight(Node* right) {
        // Configuração
        this->right = right;
        // Encadeamento
        return this;
    };

    // Captura de Expressão à Esquerda
    Node* Operator::getLeft() {
        // Captura
        return this->left;
    };

    // Captura de Expressão à Direita
    Node* Operator::getRight() {
        // Captura
        return this->right;
    };

    // Sobrescrita
    std::string Operator::toString() {
        // Apresentação
        return "Operator: '" + this->getContent() + "'";
    };

};

