/*
 * BoundingBox.cpp
 * Classe para Tratamento de Colisões
 * Padrão de Projeto Composite
 * @author Wanderson Henrique Camargo Rosa
 */

#include "BoundingBox.h"

BoundingBox::BoundingBox(Object* element)
{
    this->setMinPoint(0,0,0)->setMaxPoint(0,0,0)
        ->setObject(element)->setNext(NULL)->setChildren(NULL);
}

BoundingBox* BoundingBox::setObject(Object* element)
{
    this->element = element;
    return this;
}

BoundingBox* BoundingBox::setMinPoint(double x, double y, double z)
{
    this->box_min_x = x;
    this->box_min_y = y;
    this->box_min_z = z;
    return this;
}

BoundingBox* BoundingBox::setMaxPoint(double x, double y, double z)
{
    this->box_max_x = x;
    this->box_max_y = y;
    this->box_max_z = z;
    return this;
}

double BoundingBox::getMinX(void)
{
    return this->box_min_x + this->getObject()->getPositionX();
}

double BoundingBox::getMinY(void)
{
    return this->box_min_y + this->getObject()->getPositionY();
}

double BoundingBox::getMinZ(void)
{
    return this->box_min_z + this->getObject()->getPositionZ();
}

double BoundingBox::getMaxX(void)
{
    return this->box_max_x + this->getObject()->getPositionX();
}

double BoundingBox::getMaxY(void)
{
    return this->box_max_y + this->getObject()->getPositionY();
}

double BoundingBox::getMaxZ(void)
{
    return this->box_max_z + this->getObject()->getPositionZ();
}

BoundingBox* BoundingBox::setNext(BoundingBox* next)
{
    this->next = next;
    return this;
}

BoundingBox* BoundingBox::setChildren(BoundingBox* children)
{
    this->children = children;
    return this;
}

Object* BoundingBox::getObject(void)
{
    return this->element;
}

BoundingBox* BoundingBox::getNext(void)
{
    return this->next;
}

BoundingBox* BoundingBox::getChildren(void)
{
    return this->children;
}

bool BoundingBox::collides(BoundingBox* box)
{
    bool result = box != NULL;
    if (result) {
        result = !(box->getMaxX() < this->getMinX() || box->getMinX() > this->getMaxX() ||
                   box->getMaxY() < this->getMinY() || box->getMinY() > this->getMaxY() ||
                   box->getMaxZ() < this->getMinZ() || box->getMinZ() > this->getMaxZ());
        if (result) {
            BoundingBox* current = this->getChildren();
            result = current == NULL;
            while (!result && current != NULL) {
                result  = current->collides(box);
                current = current->getNext();
            }
        }
    }
    return result;
}
