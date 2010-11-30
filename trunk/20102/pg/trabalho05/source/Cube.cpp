/*
 * Cube.cpp
 * Desenha um Cubo no Ambiente
 */

#include "Cube.h"

Cube::Cube(void)
{
    BoundingBox* box = new BoundingBox(this);
    box->setMinPoint(0,0,0)->setMaxPoint(1,1,1);
    this->setBoundingBox(box);
}

Cube* Cube::draw(void)
{
    double x = this->getPositionX();
    double y = this->getPositionY();
    double z = this->getPositionZ();
    double a = this->getAlpha();

    glPushMatrix();
    glTranslated(x,y,z);
    glColor4d(1,1,1,a);

    glPushMatrix();
    glTranslated(0,0,1);
    this->face(); // right
    glPopMatrix();

    glPushMatrix();
    glTranslated(1,0,1);
    glRotated(90,0,1,0);
    this->face(); // back
    glPopMatrix();

    glPushMatrix();
    glTranslated(1,0,0);
    glRotated(180,0,1,0);
    this->face(); // left
    glPopMatrix();

    glPushMatrix();
    glRotated(270,0,1,0);
    this->face(); // front
    glPopMatrix();

    glPushMatrix();
    glRotated(90,1,0,0);
    this->face(); // bottom
    glPopMatrix();

    glPushMatrix();
    glTranslated(0,1,1);
    glRotated(270,1,0,0);
    this->face(); // top
    glPopMatrix();

    glPopMatrix();
    return this;
}

Cube* Cube::face(void)
{
    glBegin(GL_QUADS);
        glVertex2d(0,0);
        glVertex2d(1,0);
        glVertex2d(1,1);
        glVertex2d(0,1);
    glEnd();
}
