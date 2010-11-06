#include <GL/glut.h>
#include <math.h>
#include <iostream>
#include "GPCamera.h"

double GPCamera::PI = 3.14159265;

GPCamera::GPCamera(void)
{
    this->setRotationX(0)->setPositionX(0)->setPositionY(0)->setPositionZ(0);
}

GPCamera* GPCamera::setRotationX(int rot_x)
{
    if (rot_x < 0) rot_x = 359;
    if (rot_x >= 360) rot_x = 0;
    std::cout << rot_x << std::endl;
    this->rot_x = rot_x;
    double rad  = rot_x * PI / 180;
    this->csin  = sin(rad);
    this->ccos  = cos(rad);
    return this;
}

double GPCamera::getSin(void)
{
    return this->csin;
}

double GPCamera::getCos(void)
{
    return this->ccos;
}

GPCamera* GPCamera::setPositionX(double pos_x)
{
    this->pos_x = pos_x;
    return this;
}

GPCamera* GPCamera::setPositionY(double pos_y)
{
    this->pos_y = pos_y;
    return this;
}

GPCamera* GPCamera::setPositionZ(double pos_z)
{
    this->pos_z = pos_z;
    return this;
}

GPCamera* GPCamera::setStep(double step)
{
    this->step = step;
    return this;
}

int GPCamera::getRotationX(void)
{
    return this->rot_x;
}

double GPCamera::getPositionX(void)
{
    return this->pos_x;
}

double GPCamera::getPositionY(void)
{
    return this->pos_y;
}

double GPCamera::getPositionZ(void)
{
    return this->pos_z;
}

double GPCamera::getStep(void)
{
    return this->step;
}

GPCamera* GPCamera::place(void)
{
    double x = this->getCos();
    double z = this->getSin();

    gluLookAt(0,0,0,x,0,z,0,1,0);
    return this;
}

GPCamera* GPCamera::toRight(int size)
{
    int angle = this->getRotationX();
    this->setRotationX(angle + size);
    return this;
}

GPCamera* GPCamera::toLeft(int size)
{
    int angle = this->getRotationX();
    this->setRotationX(angle - size);
    return this;
}
