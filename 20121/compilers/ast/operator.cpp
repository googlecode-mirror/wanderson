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
        this->_left = left;
        // Encadeamento
        return this;
    };

    // Configuração de Expressão à Direita
    Operator* Operator::_setRight(Node* right) {
        // Configuração
        this->_right = right;
        // Encadeamento
        return this;
    };

    // Captura de Expressão à Esquerda
    Node* Operator::getLeft() {
        // Captura
        return this->_left;
    };

    // Captura de Expressão à Direita
    Node* Operator::getRight() {
        // Captura
        return this->_right;
    };

    // Sobrescrita
    std::string Operator::toString(int indent) {
        // Apresentação
        return std::string(indent, ' ')
            + "Operator '" + this->getContent() + "'\n"
            + this->getLeft()->toString(indent + 1) + "\n"
            + this->getRight()->toString(indent + 1);
    };

};

