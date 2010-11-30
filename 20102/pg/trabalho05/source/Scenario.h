/**
 * Scenario.h
 * Estrutura da Classe Scenario
 */

#ifndef SCENARIO_H_
#define SCENARIO_H_

#include "Object.h"

class Scenario : public Object
{
public:
    Scenario(void);
    Scenario* draw(void);
};

#endif
