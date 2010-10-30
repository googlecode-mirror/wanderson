#include <string.h>
#include <stdlib.h>
#include <stdio.h>

#define MAX_SYMBOLS 20

extern int yylineno;
extern FILE *yyin;

struct symbol
{
    char *name;
    int declare;
    int read;
    int write;
};

struct symbol mapper[MAX_SYMBOLS];

void yyerror(const char *message)
{
    fprintf(stderr,"line %d: %s\n",yylineno, message);
}

struct symbol *get(const char *name)
{
    struct symbol *pointer;
    for (pointer = mapper; pointer < &mapper[MAX_SYMBOLS]; pointer++) {
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

void output()
{
    printf("v\td\tw\tr\n");
    struct symbol *pointer;
    for (pointer = mapper; pointer < &mapper[MAX_SYMBOLS]; pointer++) {
        if (pointer->name) {
            printf("%s\t%d\t%d\t%d\n", pointer->name, pointer->declare, pointer->write, pointer->read);
        }
    }
}
