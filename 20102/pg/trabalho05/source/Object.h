/*
 * Object.h
 * Estrutura da Classe Object de Jogo
 * @author: Wanderson Henrique Camargo Rosa
 */

#ifndef OBJECT_H_
#define OBJECT_H_

#include "BoundingBox.h"
#include <cstdlib>

class BoundingBox;

class Object
{
private:
    double position_x;
    double position_y;
    double position_z;
    double alpha;
    BoundingBox* box;
public:
    Object(void);
    virtual ~Object(void);

    Object* setPositionX(double);
    Object* setPositionY(double);
    Object* setPositionZ(double);
    Object* setAlpha(double);
    Object* setBoundingBox(BoundingBox*);

    double getPositionX(void);
    double getPositionY(void);
    double getPositionZ(void);
    double getAlpha(void);
    BoundingBox* getBoundingBox(void);

    bool collides(Object*);

    virtual Object* draw(void)=0;
};

#endif
