/*
 * Laser.cpp
 * Classe Laser do Tiro
 * @author Wanderson Henrique Camargo Rosa
 */

#include "Laser.h"
#include "Camera.h"
#include "iostream"
#include <math.h>

Laser::Laser(void)
{
    this->setBoundingBox(NULL);
}

Laser* Laser::setAngle(int angle)
{
    this->angle = angle;
    return this;
}

int Laser::getAngle(void)
{
    return this->angle;
}

Laser* Laser::draw(void)
{
    int angle = this->getAngle();
    double position_x = this->getPositionX();
    double position_y = this->getPositionY();
    double position_z = this->getPositionZ();

    glColor3d(1,0,0);

    glPushMatrix();
    glTranslated(position_x, position_y, position_z);
    glRotated(angle,0,-1,0);
    glBegin(GL_LINE_LOOP);
        glVertex3d(0,0,0);
        glVertex3d(71 /* ~sqrt(2*50*50) */,0,0);
    glEnd();
    glPopMatrix();
    return this;
}

bool Laser::collides(Object* object)
{
    BoundingBox* box = object->getBoundingBox();
    if (box == NULL) {
        return false;
    }

    bool result = false;
    double radian = Game::getInstance()->getCamera()->getCameraTan();
    double position_x = this->getPositionX();
    double position_y = this->getPositionY();
    double position_z = this->getPositionZ();

    int x,y,z;

    int h = box->getMinY() <= position_y && box->getMaxY() >= position_y;

    z = radian * (box->getMinX() - position_x) + position_z;
    result = (result || ((z <= box->getMaxZ()) && (z >= box->getMinZ())));

    z = radian * (box->getMaxX() - position_x) + position_z;
    result = (result || ((z <= box->getMaxZ()) && (z >= box->getMinZ())));

    x = position_x + (box->getMinZ() - position_z) / radian;
    result = (result || ((x <= box->getMaxX()) && (x >= box->getMinX())));

    x = position_x + (box->getMaxZ() - position_z) / radian;
    result = (result || ((x <= box->getMaxX()) && (x >= box->getMinX())));

    return result && h;
}
