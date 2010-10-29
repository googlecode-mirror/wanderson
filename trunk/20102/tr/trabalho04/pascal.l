%{
#include "hashmap.h"
#include "pascal.tab.h"
%}

ID [a-zA-Z0-9][a-zA-Z0-9_]*

%%

{ID} { return IDENTIFIER; }
