package br.nom.camargo.wanderson.renato;

public class RemoteException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 1L;

    /**
     * Construtor
     * @param e Encapsulamento da Causa do Erro Gerado
     */
    public RemoteException(Throwable e)
    {
        super(e);
    }

    /**
     * Construtor
     * @param message Mensagem de Erro
     */
    public RemoteException(String message)
    {
        super(message);
    }
}
