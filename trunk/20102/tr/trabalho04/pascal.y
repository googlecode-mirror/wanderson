%{
#include "hashmap.h"
%}

%error-verbose
%union
{
    struct hashmap *hashp;
}

%token <hashp> T_IDENTIFIER
%token T_TYPEOF

%%

declare:
    T_IDENTIFIER T_TYPEOF T_IDENTIFIER { $1->declare = 1; };

%%

extern FILE *yyin;

int main(int argc, char *argv[])
{
    do {
        yyparse();
    } while (!feof(yyin));
    return 0;
}
