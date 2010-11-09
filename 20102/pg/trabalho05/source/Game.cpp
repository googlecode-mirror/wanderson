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
    this->camera  = new Camera();
    this->objects = new ObjectList();
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

ObjectList* Game::getObjects()
{
    return this->objects;
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

    Floor* floor = new Floor();
    floor->setPositionY(-1);
    this->getObjects()->add(floor);

    Cube* cube = new Cube();
    cube->setPositionX(5);
    this->getObjects()->add(cube);

    glutMainLoop();
    return this;
}

Game* Game::draw(void)
{
    int size = this->objects->size();
    int i;
    for (i = 0; i < size; i++) {
        this->objects->get(i)->draw();
    }
}
