/*
 * ObjectList.h
 * Estrutura da Classe ObjectList
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef OBJECTLIST_H_
#define OBJECTLIST_H_

#include "Object.h"
#include "ObjectNode.h"

class ObjectList
{
private:
    ObjectNode* first;
    ObjectNode* last;
public:
    ObjectList();
    ~ObjectList();

    ObjectList* add(Object*);
    Object* get(int);
    Object* remove(int);
    int size(void);
};

#endif
