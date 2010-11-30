/*
 * Game.h
 * Estrutura da Classe Game
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef GAME_H_
#define GAME_H_

#include <GL/glut.h>
#include "Camera.h"
#include "ObjectList.h"
#include "Player.h"
#include "Scenario.h"

class Camera;

class Game
{
private:
    static Game* instance;
    static int WIDTH;
    static int HEIGHT;
    static const char* NAME;
    Camera* camera;
    ObjectList* objects;
    Player* player;
    Scenario* scenario;
    Game();
public:
    static Game* getInstance(void);
    static void display(void);
    static void reshape(int,int);
    static void keyboard(unsigned char,int,int);
    Camera* getCamera(void);
    ObjectList* getObjects(void);
    Player* getPlayer(void);
    Scenario* getScenario(void);
    Game* run(int*,char**);
    Game* draw(void);
    Game* collider(void);
};

#endif
