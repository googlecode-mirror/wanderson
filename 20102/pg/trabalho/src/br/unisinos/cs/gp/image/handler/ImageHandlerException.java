package br.unisinos.cs.gp.image.handler;

/**
 * Exceção de Manipulador de Imagens
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ImageHandlerException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 6689167947006637656L;

    /**
     * Construtor com Mensagem Personalizável
     * @param message
     */
    public ImageHandlerException(String message)
    {
        super(message);
    }
}
