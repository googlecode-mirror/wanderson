#include <linux/module.h>
#include <linux/init.h>

MODULE_LICENSE("Dual BSD/CPL");
MODULE_AUTHOR("Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>");

// Assinaturas
int verifier_init(void);
void verifier_exit(void);

// Registros
module_init(verifier_init);
module_exit(verifier_exit);

/**
 * Inicialização do Módulo
 *
 * Executado durante a inicialização do módulo para configurar todos os
 * elementos necessários para o funcionamento do dispositivo.
 *
 * @return Execução com Sucesso
 */
int verifier_init(void) {
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
void verifier_exit(void) {}
