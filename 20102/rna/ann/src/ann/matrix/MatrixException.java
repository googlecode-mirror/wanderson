package ann.matrix;

/**
 * Exceção de Cálculo de Matrizes
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class MatrixException extends RuntimeException
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 6407629150262641338L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Erro
     */
    public MatrixException(String message)
    {
        super(message);
    }
}
