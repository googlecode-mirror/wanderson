package br.nom.camargo.wanderson.ann.feedforward;

/**
 * FeedForwardException Class
 * Cálculo para manipulação de exceções do pacote de redes neurais com
 * alimentação para frente
 * @author Wanderson Henrique Camargo Rosa
 */
public class FeedForwardException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 6981242819577586544L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Erro
     */
    public FeedForwardException(String message)
    {
        super(message);
    }
}
