package br.nom.camargo.wanderson.presenter;

import br.nom.camargo.wanderson.hermes.RemoteServer;
import br.nom.camargo.wanderson.hermes.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.hermes.adapter.EthernetAdapter;

public class Presenter implements Runnable
{
    private RemoteServer server;
    private PresenterRemote control;

    public Presenter()
    {
        server  = new RemoteServer();
        control = new PresenterRemote();
        server.setControl(control);
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

    public void run()
    {
        new Thread(server).start();
    }
}
