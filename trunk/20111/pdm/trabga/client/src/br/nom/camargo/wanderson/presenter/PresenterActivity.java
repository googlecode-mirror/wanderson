package br.nom.camargo.wanderson.presenter;

import java.io.IOException;
import java.io.OutputStream;
import java.util.Observable;
import java.util.Observer;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;

import br.nom.camargo.wanderson.presenter.DeviceElement.Type;
import br.nom.camargo.wanderson.renato.RemoteClient;
import br.nom.camargo.wanderson.renato.RemoteException;
import br.nom.camargo.wanderson.renato.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.renato.adapter.ConnectionAdapter;
import br.nom.camargo.wanderson.renato.adapter.EthernetAdapter;

/**
 * Apresentador de Slides
 * 
 * Trabalha como um simulador para apresentação de slides, conectando ao serviço
 * de mensagens específico e enviando mensagens para navegação. Recebe de
 * intenções parâmetros extras com o nome e tipo de conexão que deve ser feita.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class PresenterActivity extends Activity implements Observer
{
    /**
     * Dispositivo para Conexão
     */
    private DeviceElement device;

    /**
     * Cliente para Conexão
     */
    private RemoteClient client;

    /**
     * Mensagem para Envio
     */
    private String message;

    /**
     * Mensageiro de Comandos
     */
    private PresenterMessenger messenger;

    /**
     * Conector Inicial
     */
    private PresenterConnector connector;

    /**
     * Diálogo de Tentativa de Conexão
     */
    private ProgressDialog connecting;

    /**
     * Botão para Movimentação para Esquerda
     */
    private Button left;

    /**
     * Botão para Movimentação para Direita
     */
    private Button right;

    /**
     * Acesso Sincronizado de Memória Compartilhada
     * Para configuração da mensagem é necessário informar uma mensagem não
     * nula, caso contrário a mensagem será modificada e retornada.
     * @param message Mensagem para Envio
     * @return Mensagem Atual
     */
    public synchronized String access(String message)
    {
        if (message != null) {
            this.message = message;
        }
        return this.message;
    }

    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.presenter);

        /* Construção do Dispositivo */
        Intent intent = getIntent();
        String name   = intent.getStringExtra("name");
        Type type     = Type.valueOf(intent.getStringExtra("type"));
        device = ((PresenterApplication) getApplication())
            .getDatabase().retrieve(name, type);

        /* Cliente de Conexão */
        client = new RemoteClient();
        client.addObserver(this);

        /* Seleção de Adaptador */
        if (device.getType() == Type.Bluetooth) {
            /* Bluetooth */
            BluetoothAdapter b = new BluetoothAdapter();
            b.setAddress(device.getAddress());
            client.setAdapter(b);
        } else {
            /* Ethernet */
            EthernetAdapter e = new EthernetAdapter();
            e.setAddress(device.getAddress());
            e.setPort(Integer.parseInt(device.getPort()));
            client.setAdapter(e);
        }

        /* Execução Concorrente de Mensagens */
        messenger = new PresenterMessenger();

        /* Eventos em Botões */
        left  = (Button) findViewById(R.id.presenter_left);
        left.setEnabled(false);
        left.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                /* Envia Mensagem para Esquerda */
                access("LEFT");
                new Thread(messenger).start();
            }
        });
        right = (Button) findViewById(R.id.presenter_right);
        right.setEnabled(false);
        right.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                /* Envia Mensagem para Direita */
                access("RIGHT");
                new Thread(messenger).start();
            }
        });

        /* Caixa de Diálogo */
        connecting = new ProgressDialog(this);
        connecting.setTitle(getString(R.string.app_name));
        connecting.setCancelable(false);
        connecting.setMessage(getString(R.string.app_connecting));

        /* Execução Concorrente de Conexão */
        connector = new PresenterConnector();
        connector.start();

        /* Exibição da Caixa de Diálogo */
        connecting.show();
    }

    /**
     * Mensageiro de Informações
     * 
     * Criado para trabalhar de forma assíncrona para envio de mensagens,
     * possibilitando que a interface consiga ser executada normalmente
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    private class PresenterMessenger extends Thread
    {
        public void run()
        {
            /* Sincronização de Mensagem */
            byte buffer[] = access(null).getBytes();
            /* Solicita ao Adaptador a Saída de Informação */
            OutputStream output = client.getAdapter().getOutputStream();
            try {
                /* Grava na Saída a Mensagem */
                output.write(buffer.length);
                output.write(buffer);
            } catch (IOException e) {
                /* Impossível Transferência */
                System.err.println(e);
                Log.w(ConnectionAdapter.TAG, e.getMessage());
            }
        }
    }

    /**
     * Conector do Apresentador
     * 
     * Fluxo paralelo para conexão de dados evitando que a interface fique
     * bloqueada durante a tentativa inicial de conexão.
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    private class PresenterConnector extends Thread
    {
        public void run()
        {
            try {
                /* Tentativa de Conexão */
                client.connect();
            } catch (RemoteException e) {
                /* Impossível Conectar ao Servidor */
                client.disconnect();
            }
        }
    }

    public void update(Observable o, Object obj)
    {
        if (o instanceof RemoteClient) {
            RemoteClient client = (RemoteClient) o;
            switch (client.getStatus()) {
            case CONNECTED:
                left.setEnabled(true);
                right.setEnabled(true);
                break;
            case CONNECTING:
            case DISCONNECTING:
            case DISCONNECTED:
            default:
                left.setEnabled(false);
                right.setEnabled(false);
            }
        }
    }

}
