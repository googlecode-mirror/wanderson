/*
 * Laser.h
 * Estrutura da Classe Laser
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef LASER_H_
#define LASER_H_

#include "Object.h"
#include <GL/glut.h>

class Laser : public Object
{
private:
    int angle;
public:
    Laser(void);
    Laser* draw(void);
    Laser* setAngle(int);
    int getAngle(void);
};

#endif
