/**
 * Scenario.h
 * Estrutura da Classe Scenario
 */

#ifndef SCENARIO_H_
#define SCENARIO_H_

#include "Object.h"
#include <GL/glut.h>

class Scenario : public Object
{
private:
    Scenario* wall(void);
public:
    Scenario(void);
    Scenario* draw(void);
};

#endif
