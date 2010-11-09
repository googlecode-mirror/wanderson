/*
 * ObjectNode.cpp
 * Nó de Lista para Armazenamento de Objetos
 * @author Wanderson Henrique Camargo Rosa
 */

#include "ObjectNode.h"
#include <cstdlib>

ObjectNode::ObjectNode(Object* element, ObjectNode* next, ObjectNode* previous)
{
    this->setElement(element)->setNext(next)->setPrevious(previous);
}

ObjectNode::ObjectNode(Object* element, ObjectNode* next)
{
    this->setElement(element)->setNext(next)->setPrevious(NULL);
}

ObjectNode::ObjectNode(Object* element)
{
    this->setElement(element)->setNext(NULL)->setPrevious(NULL);
}

ObjectNode::~ObjectNode(void)
{
    delete this->element;
    delete this->next;
    delete this->previous;
}

ObjectNode* ObjectNode::setElement(Object* element)
{
    this->element = element;
    return this;
}

ObjectNode* ObjectNode::setNext(ObjectNode* next)
{
    this->next = next;
    return this;
}

ObjectNode* ObjectNode::setPrevious(ObjectNode* previous)
{
    this->previous = previous;
    return this;
}

Object* ObjectNode::getElement(void)
{
    return this->element;
}

ObjectNode* ObjectNode::getNext(void)
{
    return this->next;
}

ObjectNode* ObjectNode::getPrevious(void)
{
    return this->previous;
}
