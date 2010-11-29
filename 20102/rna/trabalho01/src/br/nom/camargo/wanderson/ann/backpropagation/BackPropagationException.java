package br.nom.camargo.wanderson.ann.backpropagation;

/**
 * BackPropagation Exception Class
 * Classe para manipulação de erros do pacote de treinamento de redes neurais
 * @author Wanderson Henrique Camargo Rosa
 */
public class BackPropagationException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 6827457291334896877L;

    /**
     * Construtor Padrão
     * @param message Mensagem de Erro
     */
    public BackPropagationException(String message)
    {
        super(message);
    }
}
