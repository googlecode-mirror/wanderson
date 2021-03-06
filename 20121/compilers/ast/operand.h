#ifndef AST_OPERAND
#define AST_OPERAND
#include "node.h"

namespace AST {

    /**
     * Operando
     *
     * Elemento utilizado como básico em estruturas aritméticas. Pode ser
     * considerado como constantes ou variáveis dentro do código que está sendo
     * processado.
     *
     * @category AST
     * @package  AST
     */
    class Operand : public Node {

    public:

        /**
         * Construtor
         * @param int Número do Token Utilizado
         * @param std::string Conteúdo Capturado pelo Token
         */
        Operand(int, std::string);

        // Sobrescrita
        std::string toString(int);

    };

};

#endif

