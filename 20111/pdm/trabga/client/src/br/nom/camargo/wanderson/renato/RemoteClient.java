package br.nom.camargo.wanderson.renato;

import java.util.Observable;

import android.util.Log;
import br.nom.camargo.wanderson.renato.adapter.ConnectionAdapter;

/**
 * Cliente de Mensagens
 * 
 * Utiliza um adaptador de conexão para enviar informações para a máquina local.
 * Trabalha utilizando adaptadores que encapsulam e abstraem a lógica de conexão
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class RemoteClient extends Observable
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
        status = s;
        setChanged(); notifyObservers();
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
        Log.v(ConnectionAdapter.TAG, "Client Desconectando o Cliente");
        if (adapter != null) adapter.disconnect();
        Log.v(ConnectionAdapter.TAG, "Client Cliente Desconectado");
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
