#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <signal.h>
#include <string.h>
#include <sys/types.h>
#include <sys/wait.h>

#define DOWNLOADER "wget"
#define DL_OPTIONS "-c"
#define TRUE 1
#define RESULT_FAILURE 15
#define TIMEOUT_OFF -1

int exec_dl1(int,char*);
int exec_dl2(int,char*);
void print_info(int,int,int);

int main(int argc, char* argv[]) {
    // Auxiliar para Contagem de URL
    // Posição de Argumentos para URL de Download Atual
    int counter = 1;
    // Auxiliar para Verificação de Timeout
    int timeout = TIMEOUT_OFF;

    // Verifica a Quantidade de Parâmetros Informados
    if (argc < 2) { // Contagem Adicional de Parâmetros +1
        printf("%s: Parâmetros Insuficientes\n", argv[0]);
        printf("Uso: %s [ -t timeout ] urls...\n", argv[0]);
        // Resultado do Término
        exit(RESULT_FAILURE);
    }

    // Verifica Segundo Parâmetro: Tempo de Espera
    if (strcmp(argv[1], "-t") == 0) { // Parâmetro Informado
        // Utilização de Timeout Informado
        timeout = atoi(argv[2]);
        // Deslocamento de Posição de Parâmetros
        counter = counter + 2;
    }

    // Número de Downloads com Sucesso: ns
    // Número de Downloads com Falha  : nf
    int ns = 0; int nf = 0;
    // Variáveis Auxiliáres do Laço de Repetição
    char* url; int result;
    int (*exec_dl)(int,char*);
    while (TRUE) { // Laço de Repetição Infinito
        if (counter + 1 > argc) { // Existem Downloads para Execução?
            break; // Contador Acima de Quantidade de Argumentos
        } else {
            url = argv[counter]; // Capturar URL Informada
            counter = counter + 1; // Deslocar Posição do Parâmetro
        }
        // Bloco Condicional
        switch (timeout) { // Verificar Tipo de Timeout
            case TIMEOUT_OFF: // Timeout -1 Descartável na Função
                exec_dl = &exec_dl1;
                break;
            default:
                exec_dl = &exec_dl2;
        }
        // Executar Download Selecionado
        result = exec_dl(timeout, url);
        // Verificação dos Resultados
        if (result == 0) {
            ns = ns + 1; // Successo
        } else {
            nf = nf + 1; // Falha
        }
    }

    // Apresentação de Resultados
    print_info(ns, nf, timeout);

    return EXIT_SUCCESS;
}

/**
 * Execução de Comando de Downloader sem Timeout
 * @param timeout Timeout de Execução
 * @param url Endereço para Download
 * @return Resultado do Término da Execução
 */
int exec_dl1(int timeout, char* url) {
    execl("/usr/bin/wget", DOWNLOADER, DL_OPTIONS, url, NULL);
    return EXIT_SUCCESS;
}

/**
 * Execução de Comando de Downloader com Timeout
 * @param timeout Timeout de Execução
 * @param url Endereço para Download
 * @return Resultado do Término da Execução
 */
int exec_dl2(int timeout, char* url) {
    // Capturar o PID e Esperar o Tempo Solicitado
    // Conectar a Saída de Erro na Saída Padrão
    // Terminar o Processo de Forma "Elegante"
    pid_t child = fork(); // PID do Filho
    if (child) { // Processo Pai != 0
        sleep(timeout); // Tempo de Espera
        kill(child, SIGKILL); // Término do Processo Filho
    } else { // Processo Filho
        // Execução do Download em Background
        execl("/usr/bin/wget", DOWNLOADER, DL_OPTIONS, url, NULL);
        // Finalizar Execução do Filho
        exit(EXIT_SUCCESS); // Término com Sucesso
    }
    return EXIT_SUCCESS;
}

/**
 * Impressão de Informações
 * @param ns Número de Execuções com Sucesso
 * @param nf Número de Execuções com Falha
 */
void print_info(int ns, int nf, int timeout) {
    printf("Programa de Download Utilizado: %s %s\n", DOWNLOADER, DL_OPTIONS);
    // Bloco Condicional
    if (timeout != TIMEOUT_OFF) {
        // Entra Caso Timeout é Válido
        printf("Timeout de Execução: %d\n", timeout);
    }
    printf("Número total de downloads executados: %d\n", ns + nf);
    printf("Número de downloads executados com sucesso: %d\n", ns);
}

