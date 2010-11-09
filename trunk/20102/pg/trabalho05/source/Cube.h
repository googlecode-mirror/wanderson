/*
 * Cube.h
 * Estrutura da Classe Cube
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef CUBE_H_
#define CUBE_H_

#include "Object.h"
#include <GL/glut.h>

class Cube : public Object
{
public:
    Cube* draw(void);
};

#endif
