package ann.feedforward;

/**
 * Exceção de Rede Neural Feedforward
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class FeedForwardException extends RuntimeException
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 6407629150262641338L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Erro
     */
    public FeedForwardException(String message)
    {
        super(message);
    }
}
