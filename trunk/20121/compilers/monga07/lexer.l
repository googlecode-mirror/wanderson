%option noyywrap
%option yylineno

%{
#include "parser.tab.h"
%}

NUMBER (0|[1-9][0-9]*)
ID     [_a-zA-Z][_a-zA-Z0-9]*

%%

"{" { return T_OSB; }
"}" { return T_CSB; }
"(" { return T_OPB; }
")" { return T_CPB; }
"[" { return T_OVB; }
"]" { return T_CVB; }
"," { return T_COMMA; }
";" { return T_SEMICOLON; }
"=" { return T_ASSIGN; }
"-" { return T_MINUS; }
"+" { return T_PLUS; }
"*" { return T_MUL; }
"/" { return T_DIV; }
"<" { return T_LT; }
">" { return T_GT; }
"!" { return T_NOT; }
"==" { return T_EQ; }
"<=" { return T_LE; }
">=" { return T_GE; }
"&&" { return T_SA; }
"||" { return T_SO; }
"if"     { return T_IF; }
"while"  { return T_WHILE; }
"int"    { return T_TYPE; }
"char"   { return T_TYPE; }
"float"  { return T_TYPE; }
"new"    { return T_NEW; }
"return" { return T_RETURN; }
{ID}     { return T_IDENTIFIER; }
{NUMBER} { return T_NUMBER; }

[ \t\n\r]
. { return T_UNKNOWN; }

%%
