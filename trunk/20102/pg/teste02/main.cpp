#include <cstdlib>
#include "GPGame.h"

using namespace std;

int main(int argc, char **argv)
{
    GPGame* game = GPGame::getInstance();
    game->run(&argc, argv);
    return EXIT_SUCCESS;
}
