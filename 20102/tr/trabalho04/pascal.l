%{
#include "hashmap.h"
#include "pascal.tab.c"
%}

ID [a-zA-Z0-9][a-zA-Z0-9_]*

%%

{ID} { return IDENTIFIER }
