#include <iostream>

using namespace std;

struct compromisso
{
    char qualcompromisso[20];
    int dia, mes;
};

class agenda
{
protected:
    struct compromisso *vetC;
    int totComp;
public:
    agenda(int tam)
    {
        vetC = new struct compromisso[tam];
        totComp = 0;
    }
    void mostratodoscomp();
    void inserenovocomp(char qual[20], int d, int m);
};

class novaagenda : public agenda
{
public:
    novaagenda(int tam):agenda(tam){
        lista = new struct pessoa[tam];
    }
};

int main()
{
    return 0;
}

