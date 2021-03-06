/*
 * Camera.cpp
 * Encapsulamento do Posicionamento de Câmera
 * @author Wanderson Henrique Camargo Rosa
 */

#include "Camera.h"

double Camera::PI = 3.14159265;
bool Camera::TOP = false;

Camera::Camera(void)
{
    this->setAngle(0)->setPositionX(0)->setPositionY(0)->setPositionZ(0);
}

Camera* Camera::changeView(void)
{
    Camera::TOP = !Camera::TOP;
}

Camera* Camera::setAngle(int angle)
{
    if (angle < 0) {
        angle = 359;
    } else if (angle >= 360) {
        angle = 0;
    }
    this->angle = angle;
    this->updateRadian();
    return this;
}

Camera* Camera::updateRadian(void)
{
    int angle = this->getAngle();
    double radian = angle * PI / 180;
    this->camera_sin = sin(radian);
    this->camera_cos = cos(radian);
    this->camera_tan = tan(radian);
    return this;
}

Camera* Camera::setPositionX(double position)
{
    this->position_x = position;
    return this;
}

Camera* Camera::setPositionY(double position)
{
    this->position_y = position;
    return this;
}

Camera* Camera::setPositionZ(double position)
{
    this->position_z = position;
    return this;
}

Camera* Camera::setLastDistance(double distance)
{
    this->last = distance;
    return this;
}

int Camera::getAngle(void)
{
    return this->angle;
}

double Camera::getCameraSin(void)
{
    return this->camera_sin;
}

double Camera::getCameraTan(void)
{
    return this->camera_tan;
}

double Camera::getCameraCos(void)
{
    return this->camera_cos;
}

double Camera::getPositionX(void)
{
    return this->position_x;
}

double Camera::getPositionY(void)
{
    return this->position_y;
}

double Camera::getPositionZ(void)
{
    return this->position_z;
}

double Camera::getLastDistance(void)
{
    return this->last;
}

Camera* Camera::place(void)
{
    if (!Camera::TOP) {
        double position_x = this->getPositionX();
        double position_y = this->getPositionY();
        double position_z = this->getPositionZ();
        double camera_cos = this->getCameraCos();
        double camera_sin = this->getCameraSin();

        gluLookAt(position_x,position_y,position_z,position_x + camera_cos,position_y,position_z + camera_sin,0,1,0);
    } else {
        gluLookAt(0,50,0,0,0,0,1,0,0);
    }
    return this;
}

Camera* Camera::rotate(int angle)
{
    int current = this->getAngle();
    this->setAngle(current + angle);
    return this;
}

Camera* Camera::walk(double distance)
{
    this->setLastDistance(distance);

    double position_x = this->getPositionX();
    double position_z = this->getPositionZ();

    double distance_x = this->getCameraCos() * distance;
    double distance_z = this->getCameraSin() * distance;

    this->setPositionX(position_x + distance_x)
        ->setPositionZ(position_z + distance_z);

    Player* player = Game::getInstance()->getPlayer();
    player
        ->setPositionX(this->getPositionX())
        ->setPositionY(this->getPositionY() - 2)
        ->setPositionZ(this->getPositionZ());

    if (player->collides(Game::getInstance()->getScenario())) {
        this->back();
    }

    return this;
}

Camera* Camera::climb(double distance)
{
    this->setPositionY(this->getPositionY() + distance);
    return this;
}

Camera* Camera::back(void)
{
    double distance = this->getLastDistance();
    this->walk(distance * -1);
    return this;
}
