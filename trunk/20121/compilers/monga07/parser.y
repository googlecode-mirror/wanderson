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
%token T_COMMA
%token T_OVB
%token T_CVB

%%

program
    : declaration
    ;

declaration
    : variable
    | variable declaration
    ;

variable
    : type list_identifier T_SEMICOLON
    ;

type
    : T_TYPE
    | T_TYPE T_OVB T_CVB
    ;

list_identifier
    : T_IDENTIFIER
    | T_IDENTIFIER T_COMMA list_identifier
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

