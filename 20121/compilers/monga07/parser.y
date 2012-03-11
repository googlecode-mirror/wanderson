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
%token T_IF
%token T_WHILE
%token T_NUMBER
%token T_ASSIGN
%token T_RETURN
%token T_NEW
%token T_MINUS
%token T_PLUS
%token T_MUL
%token T_DIV
%token T_LT
%token T_GT
%token T_NOT
%token T_EQ
%token T_LE
%token T_GE
%token T_SA
%token T_SO

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
    : type T_IDENTIFIER T_OPB list_parameter T_CPB scope
    ;

list_parameter
    :
    | type T_IDENTIFIER
    | type T_IDENTIFIER T_COMMA list_parameter
    ;

scope
    : T_OSB list_statement T_CSB
    ;

list_statement
    :
    | variable list_statement
    | command list_statement
    ;

command
    : T_IF T_OPB expression T_CPB command
    | T_WHILE T_OPB expression T_CPB command
    | assignment T_SEMICOLON
    | return T_SEMICOLON
    | scope
    ;

assignment
    : T_IDENTIFIER T_ASSIGN expression
    | T_IDENTIFIER T_OVB expression T_CVB T_EQ expression
    ;

return
    : T_RETURN expression
    | T_RETURN
    ;

expression
    : assignment T_SEMICOLON
    | call T_SEMICOLON
    | T_OPB expression T_CPB
    | T_NEW T_TYPE T_OVB expression T_CVB
    | T_MINUS expression
    | T_NOT expression
    | T_IDENTIFIER
    | T_NUMBER
    ;

call
    : T_IDENTIFIER T_OPB T_OPB
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
    fprintf(stderr, "line %d: error: %s\n", yylineno, s);
}

