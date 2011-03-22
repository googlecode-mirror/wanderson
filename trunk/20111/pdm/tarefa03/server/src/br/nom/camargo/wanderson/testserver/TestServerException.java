package br.nom.camargo.wanderson.testserver;

/**
 * Exceção para Tratamento do Pacote
 * @author Wanderson Henrique Camargo Rosa
 */
public class TestServerException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 1715729792872091025L;

    /**
     * Construtor com Mensagem de Erro
     * @param message Informações sobre Exceção Gerada
     */
    public TestServerException(String message)
    {
        super(message);
    }

    /**
     * Construtor como Adaptador de Exceções Aninhadas
     * @param e Exceção Aninhada
     */
    public TestServerException(Exception e)
    {
        super(e);
    }
}
