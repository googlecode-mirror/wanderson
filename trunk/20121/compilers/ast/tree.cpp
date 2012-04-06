#include <string>
#include "tree.h"
namespace AST {

    // Construtor
    Tree::Tree(Node* root) {
        // Configuração
        this->_setRoot(root);
    };

    // Configuração de Raiz
    Tree* Tree::_setRoot(Node* root) {
        // Configuração
        this->_root = root;
        // Encadeamento
        return this;
    };

    // Apresentação de Raiz
    Node* Tree::getRoot() {
        // Apresentação
        return this->_root;
    };

    // Conversão
    std::string Tree::toString() {
        // Apresentação
        return this->getRoot()->toString(0);
    };

};

