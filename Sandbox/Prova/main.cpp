#include <iostream>
#include <cstring>

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
         cout << "Todos os Compromissos" << endl;
         for(x = 0; x < totComp; x++){
            cout << vetC[x].qualcompromisso << " " << vetC[x].dia << vetC[x].mes << endl;
         }
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
            strncpy(c.qualcompromisso,qual,20);
            c.dia = d;
            c.mes = m;
            struct pessoa p;
            strncpy(p.nome,comquem,10);
            vetC[totComp] = c;
            lista[totComp] = p;
            totComp = totComp + 1;
        }
    }
    float mediames()
    {
        return totComp / 12.0;
    }
};

int main()
{
    novaagenda na(15);
    na.inserenovocomp("reuniao","Ana",27,10);
    na.inserenovocomp("exame","luiz",15,8);
    na.mostratodoscomp();
    cout << "Número medio de compromissos por mes" << na.mediames() << endl;
    return 0;
}

