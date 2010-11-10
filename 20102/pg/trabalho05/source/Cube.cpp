/*
 * Cube.cpp
 * Desenha um Cubo no Ambiente
 */

#include "Cube.h"

Cube* Cube::draw(void)
{
    double x = this->getPositionX();
    double y = this->getPositionY();
    double z = this->getPositionZ();
    glPushMatrix();
    glColor3d(255,255,255);
    glTranslated(x,y,z);
    glutSolidCube(1);
    glPopMatrix();
    return this;
}
