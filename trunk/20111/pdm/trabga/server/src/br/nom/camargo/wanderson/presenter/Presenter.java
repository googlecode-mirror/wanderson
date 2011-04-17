package br.nom.camargo.wanderson.presenter;

import java.util.Observable;

import br.nom.camargo.wanderson.hermes.RemoteControl;
import br.nom.camargo.wanderson.hermes.RemoteServer;
import br.nom.camargo.wanderson.hermes.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.hermes.adapter.EthernetAdapter;

/**
 * Apresentador de Slides
 * 
 * Configura o serviço de mensagens para trabalho com o controle de apresentação
 * com métodos adicionais que executam os adaptadores de conexão Bluetooth ou
 * Ethernet conforme necessário. Funciona como um Wrapper para o serviço de
 * mensagens, pois o acesso direto aos adaptadores não deve ser fornecido e deve
 * incluir o padrão de projeto Observer.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class Presenter extends Observable implements Runnable
{
    /**
     * Servidor de Mensagens
     */
    private RemoteServer server;

    /**
     * Construtor Padrão
     */
    public Presenter()
    {
        server = new RemoteServer();
        /* Configuração do Controle */
        RemoteControl control = new PresenterRemote();
        server.setControl(control);
    }

    /**
     * Configura o Adaptador Bluetooth
     * @return Próprio Objeto para Encadeamento
     */
    public Presenter bluetooth()
    {
        BluetoothAdapter adapter = new BluetoothAdapter();
        server.setAdapter(adapter);
        return this;
    }

    /**
     * Configura o Adaptador Ethernet
     * @return Próprio Objeto para Encadeamento
     */
    public Presenter ethernet()
    {
        EthernetAdapter adapter = new EthernetAdapter();
        server.setAdapter(adapter);
        return this;
    }

    /**
     * Desconexão de Dados
     * @return Próprio Objeto para Encadeamento
     */
    public Presenter disconnect()
    {
        server.disconnect();
        return this;
    }

    public void run()
    {
        server.run();
    }
}
