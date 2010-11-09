/*
 * ObjectList.cpp
 * Lista Encadeada de Ponteiros para Objetos
 * @author Wanderson Henrique Camargo Rosa
 */

#include "ObjectList.h"
#include <cstdlib>

ObjectList::ObjectList(void)
{
    this->first = NULL;
    this->last  = NULL;
}

ObjectList::~ObjectList(void)
{
    delete this->first;
    delete this->last;
}

ObjectList* ObjectList::add(Object* element)
{
    ObjectNode* node = new ObjectNode(element);
    if (this->first == NULL && this->last == NULL) {
        this->first = node;
        this->last  = node;
    } else {
        this->last->setNext(node);
        node->setPrevious(this->last);
        this->last = node;
    }
    return this;
}

Object* ObjectList::get(int index)
{
    ObjectNode* node = this->first;
    int counter = 0;
    while (node != NULL && counter < index) {
        counter = counter + 1;
        node = node->getNext();
    }
    return node != NULL ? node->getElement() : NULL;
}

Object* ObjectList::remove(int index)
{
    ObjectNode* before  = NULL;
    ObjectNode* current = this->first;
    int counter = 0;
    while (current != NULL && counter < index) {
        counter = counter + 1;
        before  = current;
        current = current->getNext();
    }
    if (current != NULL) {
        if (current == this->first && current == this->last) {
            this->first = NULL;
            this->last  = NULL;
        } else {
            if (current->getPrevious() != NULL) {
                current->getPrevious()->setNext(current->getNext());
            }
            if (current->getNext() != NULL) {
                current->getNext()->setPrevious(current->getPrevious());
            }
        }
    }
    return current != NULL ? current->getElement() : NULL;
}

int ObjectList::size()
{
    int counter = 0;
    ObjectNode* current = this->first;
    while (current != NULL) {
        counter = counter + 1;
        current = current->getNext();
    }
    return counter;
}
