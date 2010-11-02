#include <string.h>

struct ps_line
{
    int line;
    struct ps_line *next;
};

struct ps_symbol
{
    char *name;
    struct ps_line *declare;
    struct ps_line *read;
    struct ps_line *write;
    struct ps_symbol *next;
};

struct ps_queue
{
    struct ps_symbol *first;
};

struct ps_queue ps_createqueue()
{
    struct ps_queue queue;
    queue.first = NULL;
    return queue;
}

struct ps_symbol *ps_malloc(char *name)
{
    struct ps_symbol *p;
    p = (struct ps_symbol *) malloc(sizeof(struct ps_symbol));
    p->name = name;
    p->declare = NULL;
    p->read    = NULL;
    p->write   = NULL;
    p->next    = NULL;
    return p;
}

struct ps_symbol *ps_get(struct ps_symbol *symbol, char *name)
{
    if (!strcmp(symbol->name, name)) {
        return symbol;
    }

    if (symbol->next == NULL) {
        symbol->next = ps_malloc(name);
        return symbol->next;
    }

    return ps_get(symbol->next, name);
}

struct ps_symbol *ps_getsymbol(struct ps_queue *queue, char *name)
{
    if (queue->first == NULL) {
        queue->first = ps_malloc(name);
        return queue->first;
    }
    return ps_get(queue->first, name);
}

struct ps_line *ps_line_malloc(int line)
{
    struct ps_line *p;
    p = (struct ps_line *) malloc(sizeof(struct ps_line));
    p->line = line;
    p->next = NULL;
    return p;
}

struct ps_line *ps_line_add(struct ps_line *line, int number)
{
    if (line->next == NULL) {
        line->next = ps_line_malloc(number);
        return line->next;
    }
    return ps_line_add(line->next, number);
}

struct ps_line *ps_symbol_declare(struct ps_symbol *symbol, int number)
{
    if (symbol->declare == NULL) {
        symbol->declare = ps_line_malloc(number);
        return symbol->declare;
    }
    return ps_line_add(symbol->declare, number);
}

struct ps_line *ps_symbol_read(struct ps_symbol *symbol, int number)
{
    if (symbol->read == NULL) {
        symbol->read = ps_line_malloc(number);
        return symbol->read;
    }
    return ps_line_add(symbol->read, number);
}

struct ps_line *ps_symbol_write(struct ps_symbol *symbol, int number)
{
    if (symbol->write == NULL) {
        symbol->write = ps_line_malloc(number);
        return symbol->write;
    }
    return ps_line_add(symbol->write, number);
}
