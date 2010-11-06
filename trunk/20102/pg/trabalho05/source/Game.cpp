/*
 * Game.cpp
 * Classe para Centralização da Programação do Jogo
 * Padrão de Projeto Singleton
 * @author Wanderson Henrique Camargo Rosa
 */

#include "Game.h"

Game* Game::instance = NULL;

int Game::WIDTH = 640;
int Game::HEIGHT = 480;
const char* Game::NAME = "Graphics Processing";

Game::Game(void)
{
    this->camera = new Camera();
}

Game* Game::getInstance(void)
{
    if (instance == NULL) {
        instance = new Game();
    }
    return instance;
}

void Game::display(void)
{
    Game* game = Game::getInstance();
    glClearColor(0,0,0,0);
    glClear(GL_COLOR_BUFFER_BIT);
    glLoadIdentity();
    game->getCamera()->place();
    game->draw();
    glutSwapBuffers();
}

void Game::reshape(int width, int height)
{
    glViewport(0,0,width,height);
    int mode;
    glGetIntegerv(GL_MATRIX_MODE, &mode);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(60, width / (height * 1.0), 0, 25);
    glMatrixMode(mode);
}

void Game::keyboard(unsigned char key, int x, int y)
{
    Game* game = Game::getInstance();
    Camera* camera;
    switch (key) {
    case 'd':
        camera = game->getCamera();
        camera->rotate(2);
        break;
    case 'a':
        camera = game->getCamera();
        camera->rotate(-2);
        break;
    case 'w':
        camera = game->getCamera();
        camera->walk(0.1);
        break;
    case 's':
        camera = game->getCamera();
        camera->walk(-0.1);
        break;
    }
    glutPostRedisplay();
}

Camera* Game::getCamera(void)
{
    return this->camera;
}

Game* Game::run(int* argc, char** argv)
{
    glutInit(argc,argv);
    glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGB);
    glutInitWindowSize(WIDTH, HEIGHT);
    int position_x = (glutGet(GLUT_SCREEN_WIDTH) - WIDTH) / 2;
    int position_y = (glutGet(GLUT_SCREEN_HEIGHT) - HEIGHT) / 2;
    glutInitWindowPosition(position_x, position_y);
    glutCreateWindow(NAME);
    glutDisplayFunc(display);
    glutReshapeFunc(reshape);
    glutKeyboardFunc(keyboard);
    glutMainLoop();
    return this;
}

Game* Game::draw(void)
{
    glPushMatrix();
    glScaled(5,1,5);
    glTranslated(0,-1,0);

    glPushMatrix();
    glTranslated(0,0,-1);
    glColor3d(0,0,255);
    glBegin(GL_QUADS);
        glVertex3d(1,0,0);
        glVertex3d(0,0,0);
        glVertex3d(0,0,1);
        glVertex3d(1,0,1);
    glEnd();
    glPopMatrix();

    glPushMatrix();
    glTranslated(0,0,0);
    glColor3d(0,255,0);
    glBegin(GL_QUADS);
        glVertex3d(1,0,0);
        glVertex3d(0,0,0);
        glVertex3d(0,0,1);
        glVertex3d(1,0,1);
    glEnd();
    glPopMatrix();

    glPushMatrix();
    glTranslated(-1,0,0);
    glColor3d(255,255,0);
    glBegin(GL_QUADS);
        glVertex3d(1,0,0);
        glVertex3d(0,0,0);
        glVertex3d(0,0,1);
        glVertex3d(1,0,1);
    glEnd();
    glPopMatrix();

    glPushMatrix();
    glTranslated(-1,0,-1);
    glColor3d(255,0,0);
    glBegin(GL_QUADS);
        glVertex3d(1,0,0);
        glVertex3d(0,0,0);
        glVertex3d(0,0,1);
        glVertex3d(1,0,1);
    glEnd();
    glPopMatrix();

    glPopMatrix();

    glPushMatrix();
    glScaled(0.5,0.5,0.5);
    glTranslated(5,0,0);
    glColor3d(255,255,255);
    glutSolidCube(1);
    glPopMatrix();
}
