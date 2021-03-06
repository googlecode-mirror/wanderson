package br.nom.camargo.wanderson.hermes;

import java.io.IOException;
import java.io.InputStream;
import java.util.Observable;
import java.util.logging.Logger;

import br.nom.camargo.wanderson.hermes.adapter.ConnectionAdapter;

/**
 * Servidor de Mensagens
 * 
 * Serviço para transferência de mensagens entre o dispositivo móvel e a máquina
 * local. Trabalha utilizando adaptadores que executam a lógica especializada da
 * comunicação. Informa objeto específico das informações transferidas. Pode
 * trabalhar como um objeto executável.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class RemoteServer extends Observable implements Runnable
{
    /**
     * Estado do Servidor
     */
    public RemoteStatus status = RemoteStatus.DISCONNECTED;

    /**
     * Adaptador da Conexão
     */
    private ConnectionAdapter adapter;

    /**
     * Intepretador de Mensagens
     */
    private RemoteControl control;

    /**
     * Informação do Estado Atual do Servidor
     * @return Elemento de Informação
     */
    public RemoteStatus getStatus()
    {
        return status;
    }

    /**
     * Configuração do Estado da Conexão
     * @param s Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    private RemoteServer setStatus(RemoteStatus s)
    {
        status = s;
        setChanged(); notifyObservers();
        return this;
    }

    /**
     * Configuração do Adaptador de Conexão
     * @param adapter Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteServer setAdapter(ConnectionAdapter adapter)
    {
        /* Modificação do Adaptador em Tempo de Execução */
        if (this.adapter != null) this.adapter.disconnect();
        this.adapter = adapter;
        return this;
    }

    /**
     * Informação do Adaptador de Conexão
     * @return Elemento de Informação
     */
    public ConnectionAdapter getAdapter()
    {
        return this.adapter;
    }

    /**
     * Configuração do Interpretador de Mensagens
     * @param control Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteServer setControl(RemoteControl control)
    {
        this.control = control;
        return this;
    }

    /**
     * Informação do Interpretador de Mensagens
     * @return Elemento de Informação
     */
    public RemoteControl getControl()
    {
        return this.control;
    }

    /**
     * Conexão do Servidor de Mensagens
     * @return Próprio Objeto para Encadeamento
     * @throws RemoteException Problema Durante Conexão
     */
    public RemoteServer connect() throws RemoteException
    {
        setStatus(RemoteStatus.CONNECTING);
        if (adapter == null) {
            throw new RemoteException("Invalid Connection Adapter");
        }
        if (control == null) {
            throw new RemoteException("Invalid Remote Control");
        }
        adapter.connect();
        setStatus(RemoteStatus.CONNECTED);
        return this;
    }

    /**
     * Desconexão do Servidor de Mensagens
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteServer disconnect()
    {
        setStatus(RemoteStatus.DISCONNECTING);
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        l.info("Server Desconectando o Servidor");
        if (adapter != null) adapter.disconnect();
        l.info("Server Servidor Desconectado");
        setStatus(RemoteStatus.DISCONNECTED);
        return this;
    }

    /**
     * Verificação de Conexão Ativa
     * @return Informação sobre existência de uma conexão aberta e ativa
     */
    public boolean isConnected()
    {
        return adapter == null ? false : adapter.isConnected();
    }

    /**
     * Execução Principal do Servidor de Mensagens
     * Utiliza o adaptador de conexão para receber as informações transferidas
     * do dispositivo remoto e fornece estes dados para o interpretador.
     */
    public void run()
    {
        Logger l =
            Logger.getLogger("Hermes_RemoteLogger");
        try {
            /* Conexão do Serviço */
            l.info("Server Abrindo a Conexão de Dados");
            connect();
            l.info("Server Conexão Concluída com Sucesso");
            /* Elementos para Manipulação */
            l.info("Server Manipulando Elementos de Comunicação");
            ConnectionAdapter adapter = getAdapter();
            RemoteControl control     = getControl();
            /* Fluxo de Entrada de Dados */
            l.info("Server Abrindo Fluxo de Entrada de Dados");
            InputStream in = adapter.getInputStream();
            /* Elementos Auxiliares */
            int size; byte buffer[];
            /* Laço de Repetição para Transferência */
            while (isConnected() && (size = in.read()) > 0) {
                /* Tamanho do Conteúdo Recebido */
                l.info("Server Tamanho da Transferência: " + size + " bytes");
                buffer = new byte[size];
                l.info("Server Esperando Conteúdo da Transferência");
                in.read(buffer);
                /* Ćonteúdo Recebido */
                l.info("Server Conteúdo da Transferência: " + buffer);
                try {
                    l.info("Server Execução do Controle Remoto");
                    control.exec(this, buffer);
                } catch (RemoteException e) {
                    /* Erro de Execução */
                    l.warning("Server Erro de Execução do Controle Remoto: "
                        + e.getMessage());
                }
            }
        } catch (RemoteException e) {
            /* Erro de Conexão */
            l.warning("Server Erro de Conexão do Servidor: " + e.getMessage());
        } catch (IOException e) {
            /* Erro de Transferência de Dados */
            l.warning("Server Erro na Transferência de Dados: "
                + e.getMessage());
        } finally {
            /* Desconexão de Dados */
            disconnect();
        }
    }

    /**
     * Estado do Servidor
     *
     * @author Wanderson Henrique Camargo Rosa
     */
    public enum RemoteStatus
    {
        DISCONNECTED, CONNECTING, CONNECTED, DISCONNECTING;
    }
}
