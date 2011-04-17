package br.nom.camargo.wanderson.presenter;

import java.util.logging.Logger;

import br.nom.camargo.wanderson.hermes.RemoteServer;
import br.nom.camargo.wanderson.hermes.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.hermes.adapter.EthernetAdapter;

public class Presenter implements Runnable
{
    private RemoteServer    server;
    private PresenterRemote control;
    private PresenterView   view;

    public Presenter()
    {
        server  = new RemoteServer();
        control = new PresenterRemote();
        view    = new PresenterView();
        server.setControl(control);
        control.addObserver(view);
    }

    public Presenter bluetooth()
    {
        BluetoothAdapter adapter = new BluetoothAdapter();
        server.setAdapter(adapter);
        return this;
    }

    public Presenter ethernet()
    {
        EthernetAdapter adapter = new EthernetAdapter();
        server.setAdapter(adapter);
        return this;
    }

    public Presenter none()
    {
        server.setAdapter(null);
        return this;
    }

    public void run()
    {
        Runtime.getRuntime().addShutdownHook(new Thread(){
            public void run() {
                Logger l
                    = Logger.getLogger("Hermes_RemoteLogger");
                l.info("Presenter Disconnecting");
                server.disconnect();
                l.info("Presenter Disconnected");
            }
        });
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        l.info("Presenter Start");
        new Thread(server).start();
        l.info("Presenter Stop");
    }

    public static void main(String args[])
    {
        PresenterView v = new PresenterView();
        v.setVisible(true);
    }
}
