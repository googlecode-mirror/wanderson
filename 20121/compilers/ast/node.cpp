#include <string>
#include "node.h"

namespace AST {

    // Construtor
    Node::Node(int token, std::string content) {
        this->_setToken(token)->_setContent(content);
    };

    // Configuração
    Node* Node::_setToken(int token) {
        // Atribuição
        this->_token = token;
        // Encadeamento
        return this;
    };

    // Configuração
    Node* Node::_setContent(std::string content) {
        // Atribuição
        this->_content = content;
        // Encadeamento
        return this;
    }

    // Captura
    int Node::getToken() {
        // Apresentação
        return this->_token;
    };

    // Captura
    std::string Node::getContent() {
        return this->_content;
    }

};

