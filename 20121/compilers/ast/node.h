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
        int _token;

        /**
         * Conteúdo Capturado pelo Token
         */
        std::string _content;

        /**
         * Configuração do Token Utilizado
         *
         * Durante a análise léxica são inicializados os Tokens, identificados
         * por um número inteiro único dentro da verificação.
         *
         * @param  int Número do Token Utilizado
         * @return Próprio Objeto para Encadeamento
         */
        Node* _setToken(int);

        /**
         * Configuração do Conteúdo do Token
         *
         * Durante a etapa léxica de captura de conteúdos e divisão de Tokens, o
         * analisador armazena o conteúdo processado. Este conteúdo pode ser
         * armazenado para utilização posterior no construtor, que utiliza este
         * encapsulamento para configuração.
         *
         * @param  std::string Conteúdo Capturado pelo Token
         * @return Próprio Objeto para Encadeamento
         */
        Node* _setContent(std::string);

    public:

        /**
         * Construtor Padrão
         *
         * Construtor que deve ser utilizado como base para nós que são
         * especializados. Recebe na etapa inicial o valor do Token utilizado e
         * o conteúdo capturado pelo mesmo.
         *
         * @param int Número do Token Utilizado
         * @param std::string Conteúdo Capturado pelo Token
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
         * @param  int Posição Atual de Indentação
         * @return Conteúdo para Apresentação
         */
        virtual std::string toString(int) = 0;

    };
};

#endif

