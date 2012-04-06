#include <string>
#include "operand.h"
namespace AST {

    // Construtor
    Operand::Operand(int token, std::string content)
        : Node::Node(token, content) {};

    // Conversão
    std::string Operand::toString(int indent) {
        return std::string(indent, ' ')
            + "Operand '" + this->getContent() + "'";
    };

};
