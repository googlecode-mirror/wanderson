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
    void mostratodoscomp(){
         int x;
         /*for(x = 0; x < vetC.lenght; x++){
            cout << vetC[x].qualcompromisso<< " ";
            cout << vetC[x] << " ";
            cout << vetC[x].dia << " " <<  vetC[x].mes << " ";
         }
         cout << endl;     */
    };
    void inserenovocomp(char qual[20], int d, int m);
};

struct pessoa
{
    char nome[10];
};

class novaagenda : public agenda
{
protected:
    int max;
    struct pessoa *lista;
public:
    novaagenda(int tam) : agenda(tam)
    {
        lista = new struct pessoa[tam];
        max = tam;
    }
    void inserenovocomp(char qual[20], char comquem[10], int d, int m)
    {
        if (totComp < max) {
            struct compromisso c;
            c.qualcompromisso = qual;
            c.dia = d;
            c.mes = m;
            struct pessoa p;
            p.nome = comquem;
            vetC[totComp] = c;
            lista[totComp] = p;
            totComp = totComp + 1;
        }
    }
};

int main()
{
    return 0;
}

