#include <asm/uaccess.h>
#include <linux/module.h>
#include <linux/init.h>
#include <linux/kdev_t.h>
#include <linux/fs.h>
#include <linux/cdev.h>
#include <linux/slab.h>

// Informações
MODULE_DESCRIPTION("Driver para Verificadora de CPF e CNPJ");
MODULE_AUTHOR("Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>");
MODULE_AUTHOR("Jeferson Souza <jeferson.s.souza@hotmail.com>");
MODULE_AUTHOR("Bruno Fagundes <web@bfagundes.com>");
MODULE_VERSION("0.1b");
MODULE_LICENSE("Dual BSD/CPL");

// Definições
#define DRIVER_NAME "verifier"
#define MINOR_NUMBER 0
#define DEVICE_COUNTER 1
#define VERIFIER_SUCCESS '0'
#define VERIFIER_FAIL '1'
#define VERIFIER_WAIT '2'

// Assinaturas
int verifier_init(void);
void verifier_exit(void);
ssize_t verifier_read(struct file*, char __user*, size_t, loff_t*);
ssize_t verifier_write(struct file*, const char __user*, size_t, loff_t*);
int verifier_open(struct inode*, struct file*);
int verifier_release(struct inode*, struct file*);
char verifier_document(char*,int);

// Registros
module_init(verifier_init);
module_exit(verifier_exit);

/**
 * Número Maior do Dispositivo
 */
int MAJOR_NUMBER;

/**
 * Dispositivo
 * Valor Representante do Elemento no Sistema
 */
dev_t device;

/**
 * Dispositivo Alocado
 * Posição em Memória do Dispositivo de Caractere
 */
struct cdev *cdevice;

/**
 * Estrutura com Operadores de Arquivos
 */
struct file_operations verifier_fops = {
    .open    = verifier_open,
    .read    = verifier_read,
    .write   = verifier_write,
    .release = verifier_release,
};

/**
 * Armazenamento do Conteúdo para Manipulação
 * Código do Documento CPF e CNPJ para Verificação
 */
char *memory;

/**
 * Tamanho da Memória Inicializada
 * Utilizado para Processamento Durante Leitura
 */
int memorysize;

/**
 * Última Verificação do Processamento
 */
char lastcheck;

/**
 * Inicialização do Módulo
 *
 * Executado durante a inicialização do módulo para configurar todos os
 * elementos necessários para o funcionamento do dispositivo.
 *
 * @return Execução com Sucesso
 */
int verifier_init(void) {
    // Variáveis
    int result; // Resultado de Alocação
    // Inicialização
    printk(KERN_INFO "Inicialização de Verificadora CPF/CNPJ");
    // Alocar Dispositivo com Número Maior Dinâmico
    result = alloc_chrdev_region(&device, MINOR_NUMBER, DEVICE_COUNTER, DRIVER_NAME);
    // Verificar Resultado
    if (result == 0) {
        // Inicialização com Sucesso
        printk(KERN_INFO "Inicialização com Sucesso");
        // Capturar o Número Maior
        MAJOR_NUMBER = MAJOR(device);
        // Alocação em Memória do Dispositivo
        cdevice = cdev_alloc();
        cdevice->ops = &verifier_fops;
        result = cdev_add(cdevice, device, DEVICE_COUNTER);
        // Verificar Resultado
        if (result == 0) {
            // Alocação com Sucesso
            printk(KERN_INFO "Alocação com Sucesso");
        } else {
            // Alocação com Erros
            printk(KERN_ALERT "Impossível Alocar Dispositivo no Sistema");
        }
    } else {
        // Inicialização com Erros
        printk(KERN_ALERT "Impossível Inicializar Dispositivo");
    }
    return result;
}

/**
 * Finalização do Módulo
 *
 * Executado durante a finalização do módulo para liberar todos os recursos
 * alocados na inicialização do dispositivo.
 *
 * @return void
 */
void verifier_exit(void) {
    // Finalização
    printk(KERN_INFO "Finalização de Verificadora CPF/CNPJ");
    // Limpar Possível Dados Alocados
    kfree(memory);
    // Desalocar Dispositivo de Caractere
    cdev_del(cdevice);
    // Liberar Dispositivo Inicializado
    unregister_chrdev_region(device, DEVICE_COUNTER);
    // Finalização com Sucesso
    printk(KERN_INFO "Finalização com Sucesso");
}

/**
 * Abertura de Arquivo
 *
 * Execução para abertura do arquivo solicitado pelo sistema operacional para o
 * dispositivo. Neste caso, como não vamos trabalhar com nenhum dispositivo
 * físico, somente precisamos confirmar a execução da função.
 *
 * @param inode Representante do Arquivo no Sistema
 * @param filp  Ponteiro ao Representante de Arquivo Aberto no Sistema
 *
 * @return Confirmação de sucesso para execuções internas
 */
int verifier_open(struct inode* inode, struct file* filp) {
    printk(KERN_DEBUG "Abertura de Arquivo");
    return 0;
}

/**
 * Leitura no Dispositivo
 * 
 * Executa uma leitura no dispositivo, apresentando informações armazenadas em
 * memória local para o espaço de usuário utilizando ferramentas do Kernel.
 * Basicamente, ignora as informações solicitadas e apresenta a quantidade de
 * vezes que foi executada a leitura no dispositivo.
 *
 * @param filp   Ponteiro ao Arquivo
 * @param buffer Posição de Memória em Espaço de Usuário
 * @param count  Quantidade de Caracteres para Processamento
 * @param offp   Posição Atual do Arquivo Acessada
 *
 * @return Quantidade de bytes processados com sucesso pela leitura
 */
ssize_t verifier_read(struct file* filp, char __user* buffer, size_t count, loff_t* offp) {
    // Variáveis
    int result = -EIO; // Erro de Entrada e Saída
    // Entrada
    printk(KERN_DEBUG "Leitura em Arquivo");
    // Verificar Alocação de Memória
    if (memory != NULL) {
        // Processar Resultado
        lastcheck = verifier_document(memory, memorysize);
        printk(KERN_INFO "Resultado de Verificação: %c", lastcheck);
        // Apresentar Resposta
        if (copy_to_user(buffer, &lastcheck, 1) == 0) {
            printk(KERN_INFO "Conteúdo Lido: %c", lastcheck);
            // Limpar Memória
            kfree(memory);
            memory = NULL;
            memorysize = 0;
            // Quantidade de Leitura
            result = 1; // Somente 1 Caractere
        } else {
            // Quantidade de Bytes Processados Inválida
            printk(KERN_ALERT "Erro ao Copiar o Conteúdo de Resposta");
        }
    } else {
        // Verificar Última Leitura
        if (lastcheck == VERIFIER_SUCCESS || lastcheck == VERIFIER_FAIL) {
            // Quantidade de Leitura
            lastcheck = VERIFIER_WAIT; // Estado em Espera
            result = 0; // Sinalização de Final do Arquivo
            printk(KERN_ALERT "Final do Arquivo Encontrado");
        } else {
            printk(KERN_ALERT "Conteúdo não Inicializado Anteriormente");
        }
    }
    return result;
}

/**
 * Escrita no Dispositivo
 * 
 * Executa uma escrita no dispositivo, capturando informações armazenadas em
 * espaço de usuário e copiando para memória local utilizando ferramentas do
 * Kernel. Basicamente, contabiliza a quantidade de vezes que o dispositivo
 * efetuou uma escrita.
 *
 * @param filp   Ponteiro ao Arquivo
 * @param buffer Posição de Memória em Espaço de Usuário
 * @param count  Quantidade de Caracteres para Processamento
 * @param offp   Posição Atual do Arquivo Acessada
 *
 * @return Quantidade de bytes processados com sucesso pela escrita
 */
ssize_t verifier_write(struct file* filp, const char __user* buffer, size_t count, loff_t* offp) {
    // Variáveis
    int result = -EIO; // Erro de Entrada e Saída
    // Entrada
    printk(KERN_DEBUG "Escrita em Arquivo");
    // Tipo CPF
    if (count == 12 || count == 15) { // (CPF|CNPJ) + 1
        // Alocar Memória para Documento
        kfree(memory);
        memory = kmalloc(count, GFP_KERNEL);
        // Verificar Alocação de Memória
        if (memory != NULL) {
            // Limpeza de Memória
            memset(memory, 0, count);
            memorysize = count - 1; // Tamanho da Memória
            if (copy_from_user(memory, buffer, memorysize) == 0) {
                printk(KERN_INFO "Conteúdo Escrito: %s", memory);
                result = count; // Sucesso no Processamento
            } else {
                // Quantidade de Bytes Processados Inválida
                printk(KERN_ALERT "Erro ao Copiar Conteúdo do Documento");
            }
        } else {
            // Impossível Alocar Memória para Buffer
            printk(KERN_ALERT "Problema na Alocação de Memória");
        }
    } else {
        // Tamanho do Documento Inválido
        printk(KERN_ALERT "Documento não Reconhecido");
    }
    return result;
}

/**
 * Fechamento de Arquivo
 *
 * Execução para fechamento do arquivo solicitado pelo sistema operacional para
 * o dispositivo. Neste caso, como não vamos trabalhar com nenhum dispositivo
 * físico, somente precisamos confirmar a execução da função.
 *
 * @param inode Representante do Arquivo no Sistema
 * @param filp  Ponteiro ao Representante de Arquivo Aberto no Sistema
 *
 * @return Confirmação de sucesso para execuções internas
 */
int verifier_release(struct inode* inode, struct file* filp) {
    printk(KERN_DEBUG "Fechamento de Arquivo");
    return 0;
}

/**
 * Verificação de Documento
 *
 * Executa o algoritmo de verificação para documentos do tipo CPF e CNPJ,
 * utilizando o conteúdo apresentado como parâmetro.
 *
 * @param content Conteúdo do Documento para Verificação
 * @param size    Tamanho do Campo para Processamento
 *
 * @return Confirmação da Validade
 */
char verifier_document(char* content, int size) {
    // Variáveis
    int index; // Chave para Iterações
    int comparison; // Comparações Variadas
    // Modificadores
    int* modifiers;
    int modifiers_cpf[]  = {11,10,9,8,7,6,5,4,3,2};
    int modifiers_cnpj[] = {6,5,4,3,2,9,8,7,6,5,4,3,2};

    // Verificar Tamanho CPF ou CNPJ
    if (size == 11) {
        // Modificadores para CPF
        modifiers = modifiers_cpf;
    } else if (size == 14) {
        // Modificadores para CNPJ
        modifiers = modifiers_cnpj;
    } else {
        // Tamanho Inválido
        printk(KERN_ALERT "Tamanho do Documento Inválido");
        return VERIFIER_FAIL;
    }

    // Verificar Conteúdo com Números Somente
    for (index = 0; index < size; index = index + 1) {
        // Buscar no Intervalo [0-9]
        if (content[index] < '0' || content[index] > '9') {
            printk(KERN_ALERT "Documento Necessita Somente Números");
            return VERIFIER_FAIL;
        }
    }

    // Verificar Dígitos Expandidos
    comparison = 1; // Confirmação Inicial
    for (index = 0; index < size; index = index + 1) {
        comparison = comparison && (content[0] == content[index]);
    }
    if (comparison) {
        // Todos Dígitos Idênticos
        printk(KERN_ALERT "Documento com Dígitos Idênticos");
        return VERIFIER_FAIL;
    }

    // Verificação com Modificadores Nível 1
    comparison = 0;
    for (index = 1; index < size - 1; index = index + 1) {
        comparison = comparison + modifiers[index] * (content[index - 1] - 48); // Conversão ATOI
    }
    printk(KERN_DEBUG "Comparação Nível 1 Somatório: %d", comparison);
    comparison = comparison % 11;
    comparison = (comparison < 2 ? 0 : 11 - comparison) + 48; // Conversão ITOA
    if (comparison != content[size - 2]) {
        printk(KERN_ALERT "Verificação de Primeiro Nível Inválida");
        return VERIFIER_FAIL;
    }

    // Verificação com Modificadores Nível 2
    comparison = 0;
    for (index = 0; index < size - 1; index = index + 1) {
        comparison = comparison + modifiers[index] * (content[index] - 48); // Conversão ATOI
    }
    printk(KERN_DEBUG "Comparação Nível 2 Somatório: %d", comparison);
    comparison = comparison % 11;
    comparison = (comparison < 2 ? 0 : 11 - comparison) + 48; // Conversão ITOA
    if (comparison != content[size - 1]) {
        printk(KERN_ALERT "Verificação de Segundo Nível Inválida");
        return VERIFIER_FAIL;
    }

    printk(KERN_INFO "Verificação do Documento com Sucesso");
    return VERIFIER_SUCCESS;
}
