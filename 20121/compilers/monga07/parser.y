%error-verbose
%{
#include <stdio.h>
extern int yylineno;
extern FILE *yyin;
%}

%token T_IDENTIFIER
%token T_TYPE
%token T_SEMICOLON
%token T_UNKNOWN

%%

program
    : declaration
    ;

declaration
    : variable
    ;

variable
    : T_TYPE T_IDENTIFIER T_SEMICOLON
    ;

%%

int main(int argc, char *argv[])
{
    do {
        yyparse();
    } while (!feof(yyin));
    return 0;
}

yyerror(char *s) {
    fprintf(stderr, "error: %s\n", s);
}

