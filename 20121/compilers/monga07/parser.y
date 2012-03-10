%{
#include <stdio.h>
%}

%token T_ID
%%

program :
      '{' declaration '}'
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
      'int'
    | 'char'
    | 'float'
    ;

%%

yyerror(char *s) {
    fprintf(stderr, "error: %s\n", s);
}
