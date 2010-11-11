/*
 * Floor.cpp
 * Classe Representante do Chão
 * @author: Wanderson Henrique Camargo Rosa
 */

#include "Floor.h"

Floor* Floor::init(void)
{
    BoundingBox* box = new BoundingBox(this);
    box->setMinPoint(-5,0,-5)->setMaxPoint(5,0,5);
    this->setBoundingBox(box);
    return this;
}

Floor* Floor::draw(void)
{
    double x = this->getPositionX();
    double y = this->getPositionY();
    double z = this->getPositionZ();

    glPushMatrix();
    glTranslated(x,y,z);
    glScaled(5,1,5);

    glPushMatrix();
    glColor3d(0,255,0);
    this->piece();
    glPopMatrix();

    glPushMatrix();
    glTranslated(0,0,-1);
    glColor3d(0,0,255);
    this->piece();
    glPopMatrix();

    glPushMatrix();
    glTranslated(-1,0,0);
    glColor3d(255,255,0);
    this->piece();
    glPopMatrix();

    glPushMatrix();
    glTranslated(-1,0,-1);
    glColor3d(255,0,0);
    this->piece();
    glPopMatrix();

    glPopMatrix();
    return this;
}

Floor* Floor::piece(void)
{
    glBegin(GL_QUADS);
        glVertex3d(1,0,0);
        glVertex3d(0,0,0);
        glVertex3d(0,0,1);
        glVertex3d(1,0,1);
    glEnd();
    return this;
}
