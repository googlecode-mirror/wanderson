#include <GL/glut.h>
#include "GPCamera.h"

GPCamera::GPCamera(void)
{
    this->setRotationX(0)->setPositionX(0)->setPositionY(2)->setPositionZ(0);
}

GPCamera* GPCamera::setRotationX(int rot_x)
{
    this->rot_x = rot_x;
    return this;
}

GPCamera* GPCamera::setPositionX(int pos_x)
{
    this->pos_x = pos_x;
    return this;
}

GPCamera* GPCamera::setPositionY(int pos_y)
{
    this->pos_y = pos_y;
    return this;
}

GPCamera* GPCamera::setPositionZ(int pos_z)
{
    this->pos_z = pos_z;
    return this;
}

GPCamera* GPCamera::setStep(int step)
{
    this->step = step;
    return this;
}

int GPCamera::getRotationX(void)
{
    return this->rot_x;
}

int GPCamera::getPositionX(void)
{
    return this->pos_x;
}

int GPCamera::getPositionY(void)
{
    return this->pos_y;
}

int GPCamera::getPositionZ(void)
{
    return this->pos_z;
}

int GPCamera::getStep(void)
{
    return this->step;
}

GPCamera* GPCamera::place(void)
{
    int rot_x = this->getRotationX();
    int pos_x = this->getPositionX();
    int pos_y = this->getPositionY();
    int pos_z = this->getPositionZ();
    glRotated(rot_x, 1, 0, 0);
    glTranslated(pos_x, pos_y, pos_z);
    return this;
}
