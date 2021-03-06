/*
 * Floor.h
 * Estrutura da Classe Floor
 * @author: Wanderson Henrique Camargo Rosa
 */

#ifndef FLOOR_H_
#define FLOOR_H_

#include "Object.h"
#include "BoundingBox.h"
#include <GL/glut.h>

class Floor : public Object
{
private:
    Floor* piece(void);
public:
    Floor(void);
    Floor* draw(void);
};

#endif
