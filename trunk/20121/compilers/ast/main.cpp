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
    AST::Operand  *nodeu = new AST::Operand(0, "3");
    AST::Operator *plus  = new AST::Operator(1, "+", nodel, noder);
    AST::Operator *node  = new AST::Operator(2, "*", nodeu, plus);
    // Árvore
    AST::Tree *tree = new AST::Tree(node);
    // Renderização
    cout << tree->toString() << endl;
    return 0;
}
