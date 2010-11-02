%{
#include <stdlib.h>
#include <stdio.h>
#include "mapper.h"
struct ps_queue queue;
%}

%error-verbose

%union
{
    char *identifier;
}

%token <identifier> T_IDENTIFIER
%token T_NUMBER

%token T_BREAK
%token T_LIST
%token T_TYPEOF

%token T_PROGRAM
%token T_VAR
%token T_BEGIN
%token T_PEND

%token T_ASSIGNMENT
%token T_ADD
%token T_SUB
%token T_MUL
%token T_DIV

%token T_OB
%token T_CB

%left T_ADD T_SUB
%left T_MUL T_DIV

%%

program:
    T_PROGRAM T_IDENTIFIER T_BREAK T_VAR declare T_BEGIN statement T_PEND
  ;

declare:
    list T_TYPEOF T_IDENTIFIER T_BREAK declare
  | {}
  ;

list:
    declare_identifier
  | declare_identifier T_LIST list
  ;

statement:
    assignment T_BREAK statement
  | expression T_BREAK statement
  | procedure  T_BREAK statement
  | {}

assignment:
    write_identifier T_ASSIGNMENT expression
  ;

expression:
    expression T_ADD expression
  | expression T_SUB expression
  | expression T_MUL expression
  | expression T_DIV expression
  | T_OB expression T_OB
  | read_identifier
  | T_NUMBER
  ;

procedure:
    T_IDENTIFIER T_OB param T_CB
  ;

param:
    read_identifier
  | read_identifier T_LIST param
  ;

declare_identifier:
    T_IDENTIFIER { ps_symbol_declare(ps_getsymbol(&queue, $1), yylineno); }
  ;

write_identifier:
    T_IDENTIFIER { ps_symbol_write(ps_getsymbol(&queue, $1), yylineno); }
  ;

read_identifier:
    T_IDENTIFIER { ps_symbol_read(ps_getsymbol(&queue, $1), yylineno); }
  ;

%%

void ps_output_line(struct ps_line *element)
{
    printf("%d", element->line);
    if (element->next != NULL) {
        printf(",");
        ps_output_line(element->next);
    }
}

void ps_output_symbol(struct ps_symbol *symbol)
{
    printf("%s:(", symbol->name);
    if (symbol->declare != NULL) {
        ps_output_line(symbol->declare);
    }
    printf("),(");
    if (symbol->write != NULL) {
        ps_output_line(symbol->write);
    }
    printf("),(");
    if (symbol->read != NULL) {
        ps_output_line(symbol->read);
    }
    printf(")\n");
    if (symbol->next != NULL) {
        ps_output_symbol(symbol->next);
    }
}

void ps_output_queue(struct ps_queue *queue)
{
    printf("var:(dec),(write),(read)\n");
    if (queue->first != NULL) {
        ps_output_symbol(queue->first);
    }
}

int main(int argc, char **argv)
{
    do {
        yyparse();
    } while (!feof(yyin));
    ps_output_queue(&queue);
    return EXIT_SUCCESS;
}
