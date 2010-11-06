#include <GL/glut.h>
#include <iostream>
#include "GPCamera.h"
#include "GPGame.h"

GPGame* GPGame::instance = NULL;

int GPGame::WIDTH  = 640;
int GPGame::HEIGHT = 480;
const char* GPGame::NAME = "Graphis Processing";

GPGame::GPGame(void)
{
    camera = new GPCamera();
}

GPGame* GPGame::init(int* argc, char** argv)
{
    glutInit(argc, argv);
    glutInitDisplayMode(GLUT_DOUBLE | GLUT_DEPTH);
    glutInitWindowSize(WIDTH,HEIGHT);
    int x = (glutGet(GLUT_SCREEN_WIDTH) - WIDTH)/2;
    int y = (glutGet(GLUT_SCREEN_HEIGHT) - HEIGHT)/2;
    glutInitWindowPosition(x,y);
    glutCreateWindow(NAME);
    glutIdleFunc(display);
    glutDisplayFunc(display);
    glutReshapeFunc(reshape);
    glutKeyboardFunc(keyboard);
    return this;
}

void GPGame::display(void)
{
    GPGame* game = GPGame::getInstance();
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();
    game->getCamera()->place();
    game->draw();
    glutSwapBuffers();
}

void GPGame::reshape(int width, int height)
{
    glViewport(0, 0, width, height);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(120, width / (height * 1.0), 0, 100);
    glMatrixMode(GL_MODELVIEW);
}

void GPGame::keyboard(unsigned char key, int x, int y)
{
    GPGame* game = GPGame::getInstance();
    switch (key) {
        case 'd':
            game->getCamera()->toRight(1);
            break;
        case 'a':
            game->getCamera()->toLeft(1);
            break;
    }
}

GPGame* GPGame::getInstance(void)
{
    if (instance == NULL) {
        instance = new GPGame();
    }
    return instance;
}

void GPGame::run(int* argc, char** argv)
{
    this->init(argc, argv);
    glutMainLoop();
}

GPGame* GPGame::draw(void)
{
    glPushMatrix();
    glTranslated(2,0,0);
    glutWireCube(1);
    glPopMatrix();
}

GPCamera* GPGame::getCamera(void)
{
    return camera;
}
