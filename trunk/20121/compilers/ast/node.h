#ifndef AST_NODE
#define AST_NODE
namespace AST {

    /**
     * Árvore Abstrata de Sintaxe
     * Nó Básico de Construção
     *
     * Estrutura básica utilizada para construção de classes que são utilizadas
     * na montagem de árvores abstratas de sintaxe. Esta classe é utilizada como
     * base para construção de outras, especializadas para cada tipo de
     * necessidade durante a criação da árvore, como código intermediário do
     * processamento da gramática.
     * 
     * @category AST
     * @package  AST
     */
    class Node {

    private:

        /**
         * Token Utilizado
         */
        int token;

        /**
         * Conteúdo Capturado pelo Token
         */
        std::string content;

        /**
         * Configuração do Token Utilizado
         * @return Próprio Objeto para Encadeamento
         */
        Node* _setToken(int);

        /**
         * Configuração do Conteúdo do Token
         * @return Próprio Objeto para Encadeamento
         */
        Node* _setContent(std::string);

    public:

        /**
         * Construtor Padrão
         */
        Node(int, std::string);

        /**
         * Captura do Token Utilizado
         * @return Elemento Configurado
         */
        int getToken();

        /**
         * Captura do Conteúdo do Token Utilizado
         * @return Conteúdo Configurado
         */
        std::string getContent();

        /**
         * Renderização do Conteúdo
         * @return Conteúdo para Apresentação
         */
        virtual std::string toString() = 0;

    };
};
#endif

