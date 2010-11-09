/*
 * Object.cpp
 * Objetos do Jogo
 * @author: Wanderson Henrique Camargo Rosa
 */

#include "Object.h"

Object::Object()
{
    this->setPositionX(0)->setPositionY(0)->setPositionZ(0);
}

Object::~Object(void)
{

}

Object* Object::setPositionX(double position)
{
    this->position_x = position;
    return this;
}

Object* Object::setPositionY(double position)
{
    this->position_y = position;
    return this;
}

Object* Object::setPositionZ(double position)
{
    this->position_z = position;
    return this;
}

double Object::getPositionX(void)
{
    return this->position_x;
}

double Object::getPositionY(void)
{
    return this->position_y;
}

double Object::getPositionZ(void)
{
    return this->position_z;
}
