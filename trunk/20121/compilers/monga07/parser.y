%error-verbose
%{
#include <stdio.h>
extern int yylineno;
extern FILE *yyin;
%}

%token T_ID
%%

program :
      declaration
    ;

declaration :
      variable_declaration
    ;

variable_declaration :
      type identifier_list ';'
    ;

identifier_list :
      T_ID
    | T_ID ',' identifier_list
    ;

type :
      type_base
    | type '[' ']'

type_base :
      "int"
    | "char"
    | "float"
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
