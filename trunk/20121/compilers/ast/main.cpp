#include <iostream>
#include "operand.h"
using namespace std;
int main()
{
    AST::Operand *node = new AST::Operand(0, "+");
    cout << node->toString() << endl;
    return 0;
}
