#include <cstdlib>
#include "source/Game.h"
#include "source/Cube.h"
#include "source/Floor.h"

int main(int argc, char **argv)
{
    Game* game = Game::getInstance();

    Floor* floor = new Floor();
    game->getObjects()->add(floor);

    Cube* cube = new Cube();
    cube->setPositionX(5)->setPositionY(1);
    game->getObjects()->add(cube);

    game->getCamera()->setPositionY(1);

    game->run(&argc,argv);
    return EXIT_SUCCESS;
}
