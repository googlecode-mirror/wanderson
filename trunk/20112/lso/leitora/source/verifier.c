#include <linux/module.h>
#include <linux/init.h>
#include <linux/kdev_t.h>

MODULE_DESCRIPTION("Driver para Verificadora de CPF e CNPJ");
MODULE_AUTHOR("Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>");
MODULE_AUTHOR("Jeferson Souza <jeferson.s.souza@hotmail.com>");
MODULE_AUTHOR("Bruno Fagundes <web@bfagundes.com>");
MODULE_VERSION("0.1b");
MODULE_LICENSE("Dual BSD/CPL");

// Assinaturas
int verifier_init(void);
void verifier_exit(void);

// Registros
module_init(verifier_init);
module_exit(verifier_exit);

/**
 * Dispositivo
 * Valor Representante do Elemento no Sistema
 */
dev_t device;

/**
 * Inicialização do Módulo
 *
 * Executado durante a inicialização do módulo para configurar todos os
 * elementos necessários para o funcionamento do dispositivo.
 *
 * @return Execução com Sucesso
 */
int verifier_init(void) {
    // Inicialização
    printk(KERN_INFO "Inicialização de Verificadora CPF/CNPJ");
    // Inicialização com Sucesso
    printk(KERN_INFO "Inicialização com Sucesso");
    return 0;
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
    // Finalização com Sucesso
    printk(KERN_INFO "Finalização com Sucesso");
}

