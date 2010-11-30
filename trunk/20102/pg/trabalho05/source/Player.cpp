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
    Game* game  = Game::getInstance();
    Camera* camera = game->getCamera();
    bool result = Object::collides(object);
    if (result) {
        int modifier = camera->getLastDistance() > 0 ? 1 : -1;
        double ccos = camera->getCameraCos() * modifier;
        double csin = camera->getCameraSin() * modifier;
        object->setPositionX(object->getPositionX() + ccos);
        object->setPositionZ(object->getPositionZ() + csin);
        // Scenario Collision
        if (object->collides(game->getScenario())) {
            object->setPositionX(object->getPositionX() - ccos);
            object->setPositionZ(object->getPositionZ() - csin);
            camera->back();
        }
        // Objects Collision
        int i;
        Object* other;
        int size = game->getObjects()->size();
        for (i = 0; i < size; i++) {
            other = game->getObjects()->get(i);
            if (object != other && object->collides(other)) {
                object->setPositionX(object->getPositionX() - ccos);
                object->setPositionZ(object->getPositionZ() - csin);
                camera->back();
            }
        }
    }
    return false;
}

bool Player::collides(Scenario* scenario)
{
    bool result = Object::collides(scenario); // Encapsulation
    return result;
}
