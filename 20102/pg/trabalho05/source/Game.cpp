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
    this->camera   = new Camera();
    this->objects  = new ObjectList();
    this->player   = new Player();
    this->scenario = new Scenario();
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
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();
    game->getCamera()->place();
    game->collider();
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
    gluPerspective(60, width / (height * 1.0), 0.1, 71 /* ~sqrt(2*50*50) */);
    glMatrixMode(mode);
}

void Game::keyboard(unsigned char key, int x, int y)
{
    Game* game = Game::getInstance();
    Camera* camera;
    Object* object;
    switch (key) {
    case 'q':
        exit(0);
        break;
    case 't':
        game->getCamera()->changeView();
        break;
    case 'n':
    {
//        srand(time(NULL));
        object = new Cube();
        object->setPositionX(rand() % 40 - 20);
        object->setPositionY(rand() % 10);
        object->setPositionZ(rand() % 40 - 20);
        game->getObjects()->add(object);
    }
        break;
    case 'r':
    {
        int i;
        bool found;
        do {
            found = false;
            int size = game->getObjects()->size();
            for (i = 0; i < size && !found; i++) {
                object = game->getObjects()->get(i);
                found  = dynamic_cast<Laser*>(object) != 0;
                if (!found) {
                    found = object->getAlpha() < 1;
                }
            }
            if (found) {
                game->getObjects()->remove(i-1);
            }
        } while (found);
        break;
    }
    case 32: // space bar
    {
        camera = game->getCamera();
        Laser* laser  = new Laser();
        laser
            ->setAngle(camera->getAngle())
            ->setPositionX(camera->getPositionX())
            ->setPositionY(camera->getPositionY())
            ->setPositionZ(camera->getPositionZ());
        int i;
        int size = game->getObjects()->size();
        double distance, temp;
        Object* test = NULL;
        for (i = 0; i < size; i++) {
            object = game->getObjects()->get(i);
            if (object->getAlpha() == 1 && laser->collides(object)) {
                if (test == NULL) {
                    test = object;
                    distance = laser->distance(object);
                } else {
                    temp = laser->distance(object);
                    if (temp < distance) {
                        test = object;
                        distance = temp;
                    }
                }
            }
        }
        if (test != NULL) {
            test->setAlpha(0.5);
        }
        game->getObjects()->add(laser);
        break;
    }
    }
    glutPostRedisplay();
}

void Game::special(int key, int x, int y)
{
    Game* game = Game::getInstance();
    switch (key) {
    case GLUT_KEY_RIGHT:
        game->getCamera()->rotate(2);
        break;
    case GLUT_KEY_LEFT:
        game->getCamera()->rotate(-2);
        break;
    case GLUT_KEY_UP:
        game->getCamera()->walk(0.1);
        break;
    case GLUT_KEY_DOWN:
        game->getCamera()->walk(-0.1);
        break;
    case GLUT_KEY_PAGE_UP:
        game->getCamera()->climb(0.1);
        break;
    case GLUT_KEY_PAGE_DOWN:
        game->getCamera()->climb(-0.1);
    }
    glutPostRedisplay();
}

Camera* Game::getCamera(void)
{
    return this->camera;
}

ObjectList* Game::getObjects(void)
{
    return this->objects;
}

Player* Game::getPlayer(void)
{
    return this->player;
}

Scenario* Game::getScenario(void)
{
    return this->scenario;
}

Game* Game::run(int* argc, char** argv)
{
    glutInit(argc,argv);
    glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGBA | GLUT_DEPTH);
    glutInitWindowSize(WIDTH, HEIGHT);
    int position_x = (glutGet(GLUT_SCREEN_WIDTH) - WIDTH) / 2;
    int position_y = (glutGet(GLUT_SCREEN_HEIGHT) - HEIGHT) / 2;
    glutInitWindowPosition(position_x, position_y);
    glutCreateWindow(NAME);
    glBlendFunc(GL_SRC_ALPHA, GL_ONE_MINUS_SRC_ALPHA);
    glEnable(GL_BLEND);
    glutDisplayFunc(display);
    glutReshapeFunc(reshape);
    glutKeyboardFunc(keyboard);
    glutSpecialFunc(special);
    glClearColor(0,0,0,1);
    glPolygonMode(GL_FRONT, GL_FILL);
    glPolygonMode(GL_BACK, GL_LINE);
    glEnable(GL_DEPTH_TEST);
    glutMainLoop();
    return this;
}

Game* Game::draw(void)
{
    int i;
    int size = this->getObjects()->size();
    for (i = 0; i < size; i++) {
        this->getObjects()->get(i)->draw();
    }
    this->getPlayer()->draw();
    this->getScenario()->draw();
    return this;
}

Game* Game::collider(void)
{
    int i,j;
    Player* player = this->getPlayer();
    Scenario* scenario = this->getScenario();
    ObjectList* list = this->getObjects();
    int size = list->size();
    for (int i = 0; i < size; i++) {
        player->collides(list->get(i));
    }
    return this;
}
