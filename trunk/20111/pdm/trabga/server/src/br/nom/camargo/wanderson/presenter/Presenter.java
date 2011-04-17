package br.nom.camargo.wanderson.presenter;

import br.nom.camargo.wanderson.hermes.RemoteServer;
import br.nom.camargo.wanderson.hermes.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.hermes.adapter.EthernetAdapter;

/**
 * Apresentador de Slides
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class Presenter implements Runnable
{
    /**
     * Servidor de Mensagens
     */
    private PresenterServer server;

    /**
     * Controle de Apresentação
     */
    private PresenterRemote control;

    /**
     * Visualização do Servidor
     */
    private PresenterView view;


    /**
     * Construtor
     */
    public Presenter()
    {
        control = new PresenterRemote();
        view    = new PresenterView();
        server  = new PresenterServer();
        /* Padrão de Projeto Observador */
        control.addObserver(view);
    }

    /**
     * Inicialização de Adaptador Bluetooth
     * @return Próprio Objeto para Encadeamento
     */
    public Presenter bluetooth()
    {
        BluetoothAdapter adapter = new BluetoothAdapter();
        server.setAdapter(adapter);
        return this;
    }

    /**
     * Inicialização de Adaptador Ethernet
     * @return Próprio Objeto para Encadeamento
     */
    public Presenter ethernet()
    {
        EthernetAdapter adapter = new EthernetAdapter();
        server.setAdapter(adapter);
        return this;
    }

    /**
     * Desconexão do Servidor
     * @return Próprio Objeto para Encadeamento
     */
    public Presenter disconnect()
    {
        server.disconnect();
        return this;
    }

    public void run()
    {
        view.setDefaultCloseOperation(PresenterView.EXIT_ON_CLOSE);
        view.setVisible(true);
    }

    public static void main(String args[])
    {
        Presenter p = new Presenter();
        p.run();
    }

    /**
     * Trabalho com Gancho de Execução
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    private class PresenterServer extends RemoteServer
    {
        protected RemoteServer update()
        {
            return this;
        }
    }
}
