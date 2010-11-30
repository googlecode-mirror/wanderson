/*
 * Player.cpp
 * Classe Representante do Jogador
 * Cálculos de Bounding Box para o Jogador Atual
 * @author Wanderson Henrique Camargo Rosa
 */

#include "Player.h"
#include "Game.h"
#include "Camera.h"

Player::Player(void)
{
    BoundingBox* box = new BoundingBox(this);
    box->setMinPoint(-0.5,0.01,-0.5)->setMaxPoint(0.5,2,0.5);
    this->setBoundingBox(box);
}

Player* Player::draw(void)
{
    return this;
}

bool Player::collides(Object* object)
{
    Camera* camera = Game::getInstance()->getCamera();
    bool result = Object::collides(object);
    if (result) {
        int modifier = camera->getLastDistance() > 0 ? 1 : -1;
        double ccos = camera->getCameraCos() * modifier;
        double csin = camera->getCameraSin() * modifier;
        object->setPositionX(object->getPositionX() + ccos);
        object->setPositionZ(object->getPositionZ() + csin);
        if (object->collides(Game::getInstance()->getScenario())) {
            object->setPositionX(object->getPositionX() - ccos);
            object->setPositionZ(object->getPositionZ() - csin);
            camera->back();
        }
    }
    return false;
}

bool Player::collides(Scenario* scenario)
{
    bool result = Object::collides(scenario); // Encapsulation
    return result;
}