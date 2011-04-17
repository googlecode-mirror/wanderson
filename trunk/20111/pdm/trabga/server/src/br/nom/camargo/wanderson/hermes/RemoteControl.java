package br.nom.camargo.wanderson.hermes;

/**
 * Interpretador de Dados
 * 
 * Recebe os dados provenientes do servidor. Processa as informações de forma
 * específica, abstraindo todas as regras de conexão, encapsuladas nos
 * adaptadores do serviço de mensagens.
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public interface RemoteControl
{
    /**
     * Execução de Informações
     * @param content Conteúdo para Interpretação
     * @return Próprio Objeto para Encadeamento
     * @throws RemoteException Problemas Internos na Execução
     */
    public RemoteControl exec(RemoteServer server, byte content[])
        throws RemoteException;
}
