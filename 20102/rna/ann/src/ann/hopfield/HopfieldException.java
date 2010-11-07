package ann.hopfield;

/**
 * Exceção para Redes Hopfield
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class HopfieldException extends RuntimeException
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -2254244212419658396L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Exceção
     */
    public HopfieldException(String message)
    {
        super(message);
    }
}
