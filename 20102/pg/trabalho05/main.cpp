#include <cstdlib>
#include "source/Game.h"

int main(int argc, char **argv)
{
    Game* game = Game::getInstance();
    game->run(&argc,argv);
    return EXIT_SUCCESS;
}
