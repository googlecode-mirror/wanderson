package ann.feedforward.backpropagation;

/**
 * Exceção de Erro para o Pacote
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class BackPropagationException extends RuntimeException
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -4788064013873389732L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Erro
     */
    public BackPropagationException(String message)
    {
        super(message);
    }
}
