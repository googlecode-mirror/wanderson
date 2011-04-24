package br.nom.camargo.wanderson.renato.adapter;

import br.nom.camargo.wanderson.renato.RemoteException;

/**
 * Erro de Conexão
 * 
 * Tratamento de erros internos ao pacote.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ConnectionException extends RemoteException
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 925606106350775535L;

    /**
     * Construtor
     * @param message Mensagem de Erro
     */
    public ConnectionException(String message)
    {
        super(message);
    }

    /**
     * Construtor
     * @param e Encapsulamento da Causa sobre o Erro Gerado
     */
    public ConnectionException(Throwable e)
    {
        super(e);
    }
}
