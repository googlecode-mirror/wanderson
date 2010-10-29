%{
#include "hashmap.h"
%}

%union
{
    struct hashmap *hashp;
}

%token <hashp> IDENTIFIER

%%

declare:
    IDENTIFIER ':' IDENTIFIER { $1->declare = 1 }

%%

extern FILE *yyin;

int main(int argc, char *argv[])
{
    do {
        yyparse();
    } while (!feof(yyin));
    return 0;
}
