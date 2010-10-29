/**
 * Hashmap
 * Estrutura de Pesquisa
 */

#include <string.h>
#include <stdio.h>

/*
 * Número Máximo de Símbolos
 * Total de Elementos para Armazenar
 */
#define MAX_SYMBOLS 20

/* 
 * Estrutura de Mapeamento
 */
struct hashmap
{
    char *name;
    int declare;
    int read;
    int write;
}
hashmap[MAX_SYMBOLS];

void yyerror(char *message)
{
    fprintf(stderr,"%s\n",message);
}

/*
 * Ação Automática para Busca de Elemento
 */
struct hashmap *hashsearch(char *element)
{
    char *p;
    struct hashmap *pointer;
    for (pointer = hashmap; pointer < &hashmap[MAX_SYMBOLS]; pointer++) {
        /*
         * Ponteiro Existente
         * Informa o Ponteiro do Elemento
         */
        if (pointer->name && !strcmp(pointer->name, element)) {
            return pointer;
        }
        /*
         * Ponteiro Não Encontrado
         * Inicializa o Novo Elemento e Retorna Ponteiro
         */
        if (!pointer->name) {
            pointer->name = strdup(element);
            return pointer;
        }
    }
    yyerror("Hashmap Overflow"); 
}
