#include <cstdlib>
#include "source/Game.h"

int main(int argc, char **argv)
{
    Game* game = Game::getInstance();

    Floor* floor = new Floor();
    floor->setPositionY(-1);
    game->getObjects()->add(floor);

    Cube* cube = new Cube();
    cube->setPositionX(5);
    game->getObjects()->add(cube);

    game->run(&argc,argv);
    return EXIT_SUCCESS;
}
