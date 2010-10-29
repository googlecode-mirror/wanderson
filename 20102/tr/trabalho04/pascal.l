%option noyywrap

%{
#include "pascal.tab.h"
%}

ID [a-zA-Z0-9][a-zA-Z0-9_]*

%%

{ID} { return T_IDENTIFIER; }
":"  { return T_TYPEOF; }

[\t\n\r] 
. 
