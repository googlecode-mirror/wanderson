#include <stdio.h>
#include <string.h>

/**
 * Atividade 02
 * Laboratório de Sistemas Operacionais
 * @author Wanderson Henrique Camargo Rosa
 */
int main(int argc, char* argv[]) {
    // Variáveis
    // String de Entrada
    char input[128] = ""; // Máximo 128 Caracteres
    // Contador do Tamanho da String de Entrada
    int size = 0;

    // Captura de Entrada Padrão
    scanf("%s", input); // Armazenamento do Conteúdo

    // Cálculo do Tamanho da String de Entrada
    size = strlen(input); // Necessidade de Cabeçalho
    for (int i = 0; i < size; i++) { // Laço de Repetição para Caracteres
        printf("%c\n", input[i]); // Impressão de Caractere, um por Linha
    }

    // Retorno de Resultados ao Sistema Operacional
    return 0; // Estado de Terminação com Sucesso
}
