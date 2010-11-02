%option noyywrap
%option yylineno

%{
#include "pascal.tab.h"
#include <string.h>
%}

NUMBER ([1-9][0-9]*|0)(\.[0-9]+)?
ID     [a-z]+

%%

"program" { return T_PROGRAM; }
"var" { return T_VAR; }
"begin" { return T_BEGIN; }
"end." { return T_PEND; }

{ID} { yylval.identifier = strdup(yytext); return T_IDENTIFIER; }
{NUMBER} {return T_NUMBER; }

":=" { return T_ASSIGNMENT; }

"+" { return T_ADD; }
"-" { return T_SUB; }
"*" { return T_MUL; }
"/" { return T_DIV; }

";" { return T_BREAK; }
"," { return T_LIST; }
":" { return T_TYPEOF; }

"(" { return T_OB; }
")" { return T_CB; }

[\t\n\r] 
. 
