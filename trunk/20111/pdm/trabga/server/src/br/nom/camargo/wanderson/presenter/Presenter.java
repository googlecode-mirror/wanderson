package br.nom.camargo.wanderson.presenter;

import br.nom.camargo.wanderson.hermes.RemoteControl;
import br.nom.camargo.wanderson.hermes.RemoteServer;
import br.nom.camargo.wanderson.hermes.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.hermes.adapter.EthernetAdapter;

public class Presenter extends RemoteServer
{
    public Presenter()
    {
        RemoteControl control = new PresenterRemote();
        setControl(control);
    }

    public Presenter bluetooth()
    {
        disconnect();
        BluetoothAdapter adapter = new BluetoothAdapter();
        setAdapter(adapter);
        return this;
    }

    public Presenter ethernet()
    {
        disconnect();
        EthernetAdapter adapter = new EthernetAdapter();
        setAdapter(adapter);
        return this;
    }
}
