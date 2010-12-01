#include <cstdlib>
#include "source/Game.h"
#include "source/Cube.h"
#include "source/Floor.h"

int main(int argc, char **argv)
{
    Game* game = Game::getInstance();
    game->getCamera()->climb(2)->walk(-2);

    Floor* floor = new Floor();
    game->getObjects()->add(floor);

    Cube* cube = new Cube();
    game->getObjects()->add(cube);

    game->run(&argc,argv);
    return EXIT_SUCCESS;
}
