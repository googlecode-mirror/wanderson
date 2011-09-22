#include <stdio.h>
#include <string.h>

// Assinatura de Funções
void imprime_caracteres(char*);
void imprime_bytes_dec(char*);
void imprime_bytes_hex(long);
void imprime_bytes_bin(long);

/**
 * Atividade 02
 * Laboratório de Sistemas Operacionais
 * @author Wanderson Henrique Camargo Rosa
 */
int main(int argc, char* argv[]) {
    // Variáveis
    // String de Entrada
    char input[128] = ""; // Máximo 128 Caracteres

    // Captura de Entrada Padrão
    scanf("%s", input); // Armazenamento do Conteúdo

    // Execução de Função Encapsulada
    imprime_bytes_dec(input);

    // Retorno de Resultados ao Sistema Operacional
    return 0; // Estado de Terminação com Sucesso
}

/**
 * Impressão de Caracteres de Entrada
 * @param char* input Sequência de Caracteres
 * @return void
 */
void imprime_caracteres(char* input) {
    // Contador do Tamanho da String de Entrada
    int size; // Não Necessária Inicialização
    // Cálculo do Tamanho da String de Entrada
    size = strlen(input); // Necessidade de Cabeçalho
    for (int i = 0; i < size; i++) { // Laço de Repetição para Caracteres
        printf("%c\n", input[i]); // Impressão de Caractere, um por Linha
    }
}

/**
 * Impressão de Caracteres de Entrada
 * Exibição dos Valores em Números Decimais
 * @param char* input Sequência de Entrada
 * @return void
 */
void imprime_bytes_dec(char* input) {
    // Contador do Tamanho da String de Entrada
    int size; // Não Necessária Inicialização
    // Cálculo do Tamanho da String de Entrada
    size = strlen(input); // Necessidade de Cabeçalho
    for (int i = 0; i < size; i++) { // Laço de Repetição para Caracteres
        printf("%d\n", input[i]);
    }
}

/**
 * Impressão de Bytes para Inteiro Longo
 * Exibição dos Valores em Números Hexadecimais
 * @param long input Número para Impressão
 * @return void
 */
void imprime_bytes_hex(long input) {
    // Contador do Tamanho do Inteiro Longo de Entrada
    int size; // Não Necessária Inicialização
    // Cálculo do Tamanho do Inteiro Longo
    size = sizeof(long); // Tamanho em Bytes da Tipagem
    for (int i = 0; i < size; i++) {
        int offset = i * 8; // Deslocamento em Bits
        // Apresentação do Valor conforme Deslocamento
        printf("%.2x\n", (int) (input & (255 << offset)) >> offset);
    }
}

/**
 * Impressão de Bytes para Inteiro Longo
 * Exibição dos Valores em Números Binários
 * @param long input Número para Impressão
 * @return void
 */
void imprime_bytes_bin(long input) {
    // Contador do Tamanho do Inteiro Longo de Entrada
    int size; // Não Necessária Inicialização
    // Cálculo do Tamanho do Inteiro Longo
    size = sizeof(long); // Tamanho em Bytes da Tipagem
    for (int i = 0; i < size; i++) { // Exibição por Bytes
        for (int j = 7; j >= 0; j--) { // Exibição por Bits
            // Apresentação do Valor conforme Deslocamento
            printf("%d", (int) (input & (1 << (i * 8 + j))) >> (i * 8 + j));
        }
        printf("\n");
    }
}

