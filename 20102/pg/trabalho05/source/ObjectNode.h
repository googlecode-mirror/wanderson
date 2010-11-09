/*
 * ObjectNode.h
 * Estrutura da Classe ObjectNode
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef OBJECTNODE_H_
#define OBJECTNODE_H_

#include "Object.h"

class ObjectNode
{
private:
    Object* element;
    ObjectNode* next;
    ObjectNode* previous;
public:
    ObjectNode(Object*);
    ObjectNode(Object*, ObjectNode*);
    ObjectNode(Object*, ObjectNode*, ObjectNode*);
    ~ObjectNode(void);

    ObjectNode* setElement(Object*);
    ObjectNode* setNext(ObjectNode*);
    ObjectNode* setPrevious(ObjectNode*);

    Object* getElement(void);
    ObjectNode* getNext(void);
    ObjectNode* getPrevious(void);
};

#endif
