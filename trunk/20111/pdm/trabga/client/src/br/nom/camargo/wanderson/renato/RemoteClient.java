package br.nom.camargo.wanderson.renato;

import java.io.OutputStream;
import java.util.Observable;
import java.util.logging.Logger;

import br.nom.camargo.wanderson.renato.adapter.ConnectionAdapter;

/**
 * Cliente de Mensagens
 * 
 * Utiliza um adaptador de conexão para enviar informações para a máquina local.
 * Trabalha utilizando adaptadores que encapsulam e abstraem a lógica de conexão
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class RemoteClient extends Observable implements Runnable
{
    /**
     * Adaptador de Conexão
     */
    private ConnectionAdapter adapter;

    /**
     * Estado da Conexão
     */
    private RemoteStatus status;

    /**
     * Configura de Adaptador de Conexão
     * @param adapter Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteClient setAdapter(ConnectionAdapter adapter)
    {
        /* Modificação do Adaptador em Tempo de Execução */
        if (this.adapter != null) this.adapter.disconnect();
        this.adapter = adapter;
        return this;
    }

    /**
     * Informação de Adaptador de Conexão
     * @return Elemento de Informação
     */
    public ConnectionAdapter getAdapter()
    {
        return adapter;
    }

    /**
     * Configura o Estado da Conexão
     * @param status Elemento de Configuração
     * @return Próprio Objeto para Encadeamento
     */
    private RemoteClient setStatus(RemoteStatus s)
    {
        /* Notificação de Observadores */
        setChanged(); notifyObservers();
        status = s;
        return this;
    }

    /**
     * Informa o Estado da Conexão
     * @return Elemento de Informação
     */
    public RemoteStatus getStatus()
    {
        return status;
    }

    /**
     * Conexão com Servidor
     * Utiliza o adaptador para criar uma conexão com a máquina local
     * @return Próprio Objeto para Encadeamento
     * @throws RemoteException
     */
    public RemoteClient connect() throws RemoteException
    {
        /* Tentativa de Conexão */
        setStatus(RemoteStatus.CONNECTING);
        if (adapter == null) {
            throw new RemoteException("Invalid Connection Adapter");
        }
        adapter.connect();
        /* Conexão Estabelecida */
        setStatus(RemoteStatus.CONNECTED);
        return this;
    }

    /**
     * Desconexão com o Servidor
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteClient disconnect()
    {
        /* Tentativa de Desconexão */
        setStatus(RemoteStatus.DISCONNECTING);
        Logger l = Logger.getLogger("Renato_RemoteClient");
        l.info("Client Desconectando o Cliente");
        if (adapter != null) adapter.disconnect();
        l.info("Client Cliente Desconectado");
        /* Desconexão Estabelecida */
        setStatus(RemoteStatus.DISCONNECTED);
        return this;
    }

    /**
     * Verificação de Conexão Ativa
     * @return Informação sobre a existência de uma conexão ativa
     */
    public boolean isConnected()
    {
        return adapter == null ? false : adapter.isConnected();
    }

    public void run()
    {
        Logger l = Logger.getLogger("Renato_RemoteLogger");
        try {
            /* Conexão com o Serviço de Mensagens */
            l.info("Client Abrindo Conexão de Dados");
            connect();
            l.info("Client Conexão Concluída com Sucesso");
            /* Elementos de Manipulação */
            l.info("Client Manipulando Elementos de Comunicação");
            ConnectionAdapter adapter = getAdapter();
            /* Fluxo de Entrada de Dados */
            l.info("Client Abrindo Fluxo de Saída de Dados");
            /* Manipulação de Informação */
            OutputStream out = adapter.getOutputStream();
        } catch (RemoteException e) {
            l.warning("Client Erro de Conexão: " + e.getMessage());
        } finally {
            disconnect();
        }
    }

    /**
     * Estado da Conexão
     * 
     * @author Wanderson Henrique Camargo Rosa
     *
     */
    public enum RemoteStatus
    {
        DISCONNECTED, CONNECTING, CONNECTED, DISCONNECTING;
    }
}
