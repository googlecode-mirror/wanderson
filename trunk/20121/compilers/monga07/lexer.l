%option noyywrap
%option yylineno

%{
#include "parser.tab.h"
%}

ID [_a-zA-Z][_a-zA-Z0-9]*

%%

";" { return T_SEMICOLON; }
"int" { return T_TYPE; }
{ID} { return T_IDENTIFIER; }

[ \t\n\r]
. { return T_UNKNOWN; }

%%
