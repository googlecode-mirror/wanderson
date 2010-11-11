/**
 * BoundingBox.h
 * Estrutura da Classe BoundingBox
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef BOUNDINGBOX_H_
#define BOUNDINGBOX_H_

#include "Object.h"
#include <cstdlib>

class Object;

class BoundingBox
{
private:
    static const char X_AXIS = 'x';
    static const char Y_AXIS = 'y';
    static const char Z_AXIS = 'z';

    Object* element;
    BoundingBox* next;
    BoundingBox* children;

    double box_min_x;
    double box_min_y;
    double box_min_z;

    double box_max_x;
    double box_max_y;
    double box_max_z;

    BoundingBox* setObject(Object*);
    BoundingBox* setMinPoint(double,double,double);
    BoundingBox* setMaxPoint(double,double,double);
    bool belongs(char,double);

public:
    BoundingBox(Object*);

    BoundingBox* setNext(BoundingBox*);
    BoundingBox* setChildren(BoundingBox*);

    double getMinX(void);
    double getMinY(void);
    double getMinZ(void);
    double getMaxX(void);
    double getMaxY(void);
    double getMaxZ(void);

    Object* getObject(void);
    BoundingBox* getNext(void);
    BoundingBox* getChildren(void);

    bool collides(BoundingBox*);
};

#endif
