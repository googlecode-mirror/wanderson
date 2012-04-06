#include <iostream>
#include "operand.h"
#include "operator.h"
#include "tree.h"
using namespace std;
int main()
{
    // Expressão
    AST::Operand  *nodel = new AST::Operand(0, "1");
    AST::Operand  *noder = new AST::Operand(0, "2");
    AST::Operator *node  = new AST::Operator(1, "+", nodel, noder);
    // Árvore
    AST::Tree *tree = new AST::Tree(node);
    // Renderização
    cout << tree->toString() << endl;
    return 0;
}
