#include <GL/glut.h>
#include "GPCamera.h"
#include "GPGame.h"

GPGame* GPGame::instance = NULL;

int GPGame::WIDTH  = 640;
int GPGame::HEIGHT = 480;
const char* GPGame::NAME = "Graphis Processing";

GPGame::GPGame()
{
    camera = new GPCamera();
}

GPGame* GPGame::init(int* argc, char** argv)
{
    glutInit(argc, argv);
    glutInitDisplayMode(GLUT_SINGLE);
    glutInitWindowSize(WIDTH,HEIGHT);
    int x = (glutGet(GLUT_SCREEN_WIDTH) - WIDTH)/2;
    int y = (glutGet(GLUT_SCREEN_HEIGHT) - HEIGHT)/2;
    glutInitWindowPosition(x,y);
    glutCreateWindow(NAME);
    glutDisplayFunc(display);
    glutReshapeFunc(reshape);
    return this;
}

void GPGame::display(void)
{
    GPGame* game = GPGame::getInstance();
    glClear(GL_COLOR_BUFFER_BIT);
    game->getCamera()->place();
    glFlush();
}

void GPGame::reshape(int width, int height)
{
    glViewport(0, 0, width, height);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(120, width / (height * 1.0), 0, 100);
    glMatrixMode(GL_MODELVIEW);
}

GPGame* GPGame::getInstance()
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

GPCamera* GPGame::getCamera(void)
{
    return camera;
}
