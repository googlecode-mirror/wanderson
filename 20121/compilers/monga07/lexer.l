%option noyywrap
%option yylineno

%{
#include "parser.tab.h"
%}

ID [_a-zA-Z][_a-zA-Z0-9]*

%%

"{" { return T_OSB; }
"}" { return T_CSB; }
"(" { return T_OPB; }
")" { return T_CPB; }
"[" { return T_OVB; }
"]" { return T_CVB; }
"," { return T_COMMA; }
";" { return T_SEMICOLON; }
"int"|"char"|"float" { return T_TYPE; }
{ID} { return T_IDENTIFIER; }

[ \t\n\r]
. { return T_UNKNOWN; }

%%
