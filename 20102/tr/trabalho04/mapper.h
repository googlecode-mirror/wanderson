#include <string.h>
#include <stdlib.h>
#include <stdio.h>

#define MAX_SYMBOLS 20

struct symbol
{
    char *name;
    int declare;
    int read;
    int write;
};

symbol mapper[MAX_SYMBOLS];

void yyerror(const char *message)
{
    fprintf(stderr,"%s\n",message);
}

symbol *get(const char *name)
{
    symbol *pointer;
    for (pointer = mapper; pointer <= &mapper[MAX_SYMBOLS]; pointer++) {
        if (pointer->name && !strcmp(name, pointer->name)) {
            return pointer;
        }
        if (!pointer->name) {
            pointer->name = strdup(name);
            return pointer;
        }
    }
    yyerror("Mapper Overflow");
    exit(EXIT_FAILURE);
}
