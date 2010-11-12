/*
 * Player.h
 * Estrutura da Classe Player
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef PLAYER_H_
#define PLAYER_H_

#include "Object.h"
#include "BoundingBox.h"

class Player : public Object
{
public:
    Player(void);
    Player* draw(void);
    bool collides(Object*);
};

#endif
