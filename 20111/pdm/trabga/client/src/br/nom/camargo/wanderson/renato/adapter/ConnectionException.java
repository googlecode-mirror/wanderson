package br.nom.camargo.wanderson.renato.adapter;

/**
 * Erro de Conexão
 * 
 * Tratamento de erros internos ao pacote.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ConnectionException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 925606106350775535L;

    /**
     * Construtor
     * @param e Encapsulamento da Causa sobre o Erro Gerado
     */
    public ConnectionException(Throwable e)
    {
        super(e);
    }
}
