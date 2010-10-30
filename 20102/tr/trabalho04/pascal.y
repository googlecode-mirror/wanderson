%{
#include "mapper.h"
%}

%error-verbose
%union
{
    const char *identifier;
}

%token <identifier> T_IDENTIFIER
%token T_NUMBER
%token T_TYPEOF
%token T_END
%token T_WRITE
%token T_READ
%token T_OB
%token T_CB

%%

declare:
    T_IDENTIFIER { get($1)->declare = yylineno } T_TYPEOF T_IDENTIFIER declare
  | T_IDENTIFIER { get($1)->write = yylineno } T_WRITE input
  | T_READ T_OB T_IDENTIFIER { get($3)->read = yylineno } T_CB declare
  | T_IDENTIFIER declare
  | T_END
  ;

input:
    T_IDENTIFIER { get($1)->read = yylineno } declare
  | T_NUMBER declare
  ;

%%

int main(int argc, char *argv[])
{
    do {
        yyparse();
    } while (!feof(yyin));
    output();
    return 0;
}
