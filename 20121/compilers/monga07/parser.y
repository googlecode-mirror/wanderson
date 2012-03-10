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
%token T_OPB
%token T_CPB
%token T_OSB
%token T_CSB

%%

program
    : declaration
    ;

declaration
    : variable
    | variable declaration
    | function
    | function declaration
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

function
    : type T_IDENTIFIER T_OPB list_parameter T_CPB T_OSB scope T_CSB
    ;

list_parameter
    :
    | type T_IDENTIFIER
    | type T_IDENTIFIER T_COMMA list_parameter
    ;

scope
    :
    | variable scope
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

