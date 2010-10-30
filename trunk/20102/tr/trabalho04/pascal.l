%option noyywrap
%option yylineno

%{
#include "pascal.tab.h"
%}

NUMBER [1-9][0-9]*(\.[0-9]+)?
ID     [a-zA-Z][a-zA-Z0-9_]*

%%

"end."    { return T_END; }
"writeln" { return T_READ; }
{NUMBER}  { return T_NUMBER; }
{ID}      { yylval.identifier = yytext; return T_IDENTIFIER; }
":="      { return T_WRITE; }
":"       { return T_TYPEOF; }
"("       { return T_OB; }
")"       { return T_CB; }

[\t\n\r] 
. 
