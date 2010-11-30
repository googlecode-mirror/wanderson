/*
 * Laser.cpp
 * Classe Laser do Tiro
 * @author Wanderson Henrique Camargo Rosa
 */

#include "Laser.h"

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
        glVertex3d(10,0,0);
    glEnd();
    glPopMatrix();
    return this;
}
