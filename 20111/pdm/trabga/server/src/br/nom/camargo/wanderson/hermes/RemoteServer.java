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
     * Execução Principal do Servidor de Mensagens
     * Utiliza o adaptador de conexão para receber as informações transferidas
     * do dispositivo remoto e fornece estes dados para o interpretador.
     */
    public void run()
    {
        /* Captura de Elementos Necessários */
        RemoteControl control     = getControl();
        ConnectionAdapter adapter = getAdapter();
        if (control != null && adapter != null) {
            /* Fluxo de Dados */
            InputStream in   = adapter.getInputStream();
            if (in != null) {
                int size = 0;
                byte buffer[];
                /* Manipulação da Conexão */
                try {
                    while ((size = in.read()) > 0) {
                        buffer = new byte[size];
                        in.read(buffer);
                        control.exec(buffer);
                    }
                } catch (IOException e) {
                    /* Problema na Conexão */
                } catch (RemoteException e) {
                    /* Problema na Execução */
                }
            } else {
                /* Fluxos de Dados Não Informados */
            }
        } else {
            /* Elementos Necessários Não Informados */
        }
    }
}
