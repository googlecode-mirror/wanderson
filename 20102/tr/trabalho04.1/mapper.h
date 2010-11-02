#include <stdio.h>
#include "queue.h"

extern int yylineno;
extern FILE *yyin;

void yyerror(const char *message)
{
    fprintf(stderr,"line %d: %s\n",yylineno, message);
}
