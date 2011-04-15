package br.nom.camargo.wanderson.hermes;

/**
 * Erro de Serviço de Mensagens
 * 
 * Tratamento de erros internos ao pacote.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class RemoteException extends Exception
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -2559267017643920482L;

    /**
     * Construtor
     * @param e Encapsulamento da Causa sobre Erro Gerado
     */
    public RemoteException(Throwable e)
    {
        super(e);
    }
}
