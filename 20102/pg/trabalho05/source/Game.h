/*
 * Game.h
 * Estrutura da Classe Game
 * @author Wanderson Henrique Camargo Rosa
 */

#ifndef GAME_H_
#define GAME_H_

#include <GL/glut.h>
#include <math.h>
#include "Camera.h"

class Game
{
private:
    static Game* instance;
    static int WIDTH;
    static int HEIGHT;
    static const char* NAME;
    Camera* camera;
    Game();
public:
    static Game* getInstance(void);
    static void display(void);
    static void reshape(int,int);
    static void keyboard(unsigned char,int,int);
    Camera* getCamera(void);
    Game* run(int*,char**);
    Game* draw(void);
};

#endif
