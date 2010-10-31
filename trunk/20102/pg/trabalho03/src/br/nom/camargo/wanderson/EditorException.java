package br.nom.camargo.wanderson;

/**
 * Objeto de Manipulação de Erros do Editor
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class EditorException extends RuntimeException
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -7680646964690900344L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Erro
     */
    public EditorException(String message)
    {
        super(message);
    }
}
