%option noyywrap

%{
#include "parser.tab.h"
%}

T_ID [a-zA-Z0-9][a-zA-Z0-9_]*

%%

T_ID { return T_ID; }
.

%%
