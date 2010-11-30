/**
 * BoundingBox.h
 * Estrutura da Classe BoundingBox
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef BOUNDINGBOX_H_
#define BOUNDINGBOX_H_

#include "Object.h"

class Object;

class BoundingBox
{
private:
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

public:
    BoundingBox(Object*);
    BoundingBox* setMinPoint(double,double,double);
    BoundingBox* setMaxPoint(double,double,double);

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
