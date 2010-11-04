#include <iostream>
#include <cstdlib>
#include <string>
#include <GL/glut.h>
#include "GPGame.h"

using namespace std;

int main(int argc, char **argv)
{
    glutInit(&argc, argv);
    GPGame* game = GPGame::getInstance();
    game->run();
    return EXIT_SUCCESS;
}
