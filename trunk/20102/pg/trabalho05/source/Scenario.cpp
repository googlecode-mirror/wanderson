/**
 * Scenario.cpp
 * Classe Representante do Cenário do Jogo
 * @author Wanderson Henrique Camargo Rosa
 */

#include "Scenario.h"

Scenario::Scenario(void)
{

}

Scenario* Scenario::draw(void)
{
    glPushMatrix();

    glColor3d(0.1,0.1,0.1);

    glPushMatrix();
    glTranslated(-25,0,-25);
    this->wall(); // left
    glPopMatrix();

    glPushMatrix();
    glTranslated(25,0,25);
    glRotated(180,0,1,0);
    this->wall(); // right
    glPopMatrix();

    glColor3d(0.2,0.2,0.2);

    glPushMatrix();
    glTranslated(25,0,-25);
    glRotated(270,0,1,0);
    this->wall(); // front
    glPopMatrix();

    glPushMatrix();
    glTranslated(-25,0,25);
    glRotated(90,0,1,0);
    this->wall(); // back
    glPopMatrix();

    glPopMatrix();
    return this;
}

Scenario* Scenario::wall(void)
{
    glBegin(GL_QUADS);
        glVertex2d(0,0);
        glVertex2d(50,0);
        glVertex2d(50,10);
        glVertex2d(0,10);
    glEnd();
    return this;
}
