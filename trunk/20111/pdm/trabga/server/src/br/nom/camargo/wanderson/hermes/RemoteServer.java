package br.nom.camargo.wanderson.hermes;

import java.io.IOException;
import java.io.InputStream;

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
public class RemoteServer implements Runnable
{
    /**
     * Adaptador da Conexão
     */
    private ConnectionAdapter adapter;

    /**
     * Intepretador de Mensagens
     */
    private RemoteControl control;

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
        if (adapter == null) {
            throw new RemoteException("Invalid Connection Adapter");
        }
        if (control == null) {
            throw new RemoteException("Invalid Remote Control");
        }
        adapter.connect();
        return this;
    }

    /**
     * Desconexão do Servidor de Mensagens
     * @return Próprio Objeto para Encadeamento
     */
    public RemoteServer disconnect()
    {
        if (adapter != null) adapter.disconnect();
        return this;
    }

    /**
     * Verificação de Conexão Ativa
     * @return Informação sobre existência de uma conexão aberta e ativa
     */
    public boolean isConnected()
    {
        return adapter.isConnected();
    }

    /**
     * Execução Principal do Servidor de Mensagens
     * Utiliza o adaptador de conexão para receber as informações transferidas
     * do dispositivo remoto e fornece estes dados para o interpretador.
     */
    public void run()
    {
        try {
            /* Conexão do Serviço */
            connect();
            /* Elementos para Manipulação */
            ConnectionAdapter adapter = getAdapter();
            RemoteControl control     = getControl();
            /* Fluxo de Entrada de Dados */
            InputStream in = adapter.getInputStream();
            /* Elementos Auxiliares */
            int size; byte buffer[];
            /* Laço de Repetição para Transferência */
            while (isConnected()) {
                size = in.read();
                buffer = new byte[size];
                in.read(buffer);
                try {
                    control.exec(this, buffer);
                } catch (RemoteException e) {
                    /* Erro de Execução */
                }
            }
        } catch (RemoteException e) {
            /* Erro de Conexão */
        } catch (IOException e) {
            /* Erro de Transferência de Dados */
        } finally {
            /* Desconexão de Dados */
            disconnect();
        }
    }
}
