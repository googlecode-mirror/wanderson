/*
 * Camera.h
 * Estrutura da Classe Camera
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef CAMERA_H_
#define CAMERA_H_

#include <GL/glut.h>
#include <math.h>
#include "Game.h"
#include "Player.h"

class Camera
{
    static bool TOP;
    int angle;
    double camera_sin;
    double camera_cos;
    double position_x;
    double position_y;
    double position_z;
    double last;
    Camera* updateRadian(void);
    Camera* setLastDistance(double);
public:
    static double PI;
    Camera(void);
    Camera* setAngle(int);
    Camera* setPositionX(double);
    Camera* setPositionY(double);
    Camera* setPositionZ(double);
    Camera* changeView();
    int getAngle(void);
    double getCameraSin(void);
    double getCameraCos(void);
    double getPositionX(void);
    double getPositionY(void);
    double getPositionZ(void);
    double getLastDistance(void);
    Camera* place(void);
    Camera* rotate(int);
    Camera* walk(double);
    Camera* climb(double);
    Camera* back();
};

#endif
