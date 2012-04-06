#include <iostream>
#include "operand.h"
#include "operator.h"
using namespace std;
int main()
{
    AST::Operand *nodel = new AST::Operand(0, "1");
    AST::Operand *noder = new AST::Operand(0, "2");
    AST::Operator *node = new AST::Operator(1, "+", nodel, noder);
    cout << node->toString() << endl;
    return 0;
}
