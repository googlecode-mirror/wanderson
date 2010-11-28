package br.nom.camargo.wanderson.ann.matrix;

/**
 * Matrix Exception
 * Classe para manipulação de exceções ao pacote de cálculos sobre matrizes
 * utilizado pelos pesos das redes neurais artificiais
 * @author Wanderson Henrique Camargo Rosa
 */
public class MatrixException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -4496688296007220111L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Exceção
     */
    public MatrixException(String message)
    {
        super(message);
    }
}
