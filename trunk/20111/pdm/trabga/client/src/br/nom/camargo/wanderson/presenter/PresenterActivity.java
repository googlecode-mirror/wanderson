package br.nom.camargo.wanderson.presenter;

import java.util.Observable;
import java.util.Observer;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import br.nom.camargo.wanderson.presenter.DeviceElement.Type;
import br.nom.camargo.wanderson.renato.RemoteClient;
import br.nom.camargo.wanderson.renato.RemoteClient.RemoteStatus;
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
public class PresenterActivity extends Activity implements OnClickListener
{
    /**
     * Requisição entre Atividades
     * Habilitar Bluetooth
     */
    private static final int REQUEST_ENABLE_BLUETOOTH = 0;

    /**
     * Requisição entre Atividades
     * Habilitar Ethernet
     */
    private static final int REQUEST_ENABLE_ETHERNET = 1;

    /**
     * Manipulador da Camada de Visualização
     * Auxilia na Comunicação entre Diferentes Fluxos de Execução
     */
    private PresenterHandler handler;

    /**
     * Cliente para Conexão no Servidor de Mensagens
     */
    private RemoteClient client;

    /**
     * Botão de Navegação para Esquerda
     */
    private Button left;

    /**
     * Botão de Navegação para Direita
     */
    private Button right;

    /**
     * Diálogo de Progresso de Conexão
     */
    private ProgressDialog dialog;

    /*
     * Tempo de Criação da Atividade
     */
    public void onCreate(Bundle state)
    {
        super.onCreate(state);
        setContentView(R.layout.presenter);

        /* User Interface */
        left  = (Button) findViewById(R.id.presenter_left);
        left.setOnClickListener(this);
        right = (Button) findViewById(R.id.presenter_right);
        right.setOnClickListener(this);

        /* Caixa de Diálogo */
        dialog = new PresenterDialog();

        /* Manipulador da Interface */
        handler = new PresenterHandler();

        /* Conexão Remota */
        client = new RemoteClient();
        client.addObserver(handler);

        /* Configuração do Dispositivo */
        client.setAdapter(getConnectionAdapter());

        /* Conector ao Serviço */
        PresenterConnector connector = new PresenterConnector();
        connector.start();
    }

    /*
     * Tempo de Destruição da Atividade
     * Desconecta o Cliente do Servidor
     */
    public void onDestroy()
    {
        super.onDestroy();
        client.disconnect();
    }

    /*
     * Manipulador dos Comandos de Botões
     */
    public void onClick(View view)
    {
        if (view == left) {
            /** TODO Mensagem para Esquerda */
        }
        if (view == right) {
            /** TODO Mensagem para Direita */
        }
    }

    /**
     * Filtro para Captura do Dispositivo para Conexão
     * Encapsulamento de Regras Específicas conforme Informações da Intensão
     * @return Adaptador para Conexão do Cliente
     */
    public ConnectionAdapter getConnectionAdapter()
    {
        /* Intensão da Atividade */
        Intent intent = getIntent();

        /* Informações para Criação do Dispositivo */
        String name = intent.getStringExtra("name");
        Type   type = Type.valueOf(intent.getStringExtra("type"));

        /* Dispositivo Cadastrado */
        DeviceElement device = ((PresenterApplication) getApplication())
            .getDatabase().retrieve(name, type);

        /*
         * Adaptador de Conexão
         */
        ConnectionAdapter adapter = null;

        /* Blocos Condicionais */
        if (device.getType() == Type.Bluetooth) {
            /* Dispositivo Bluetooth */
            BluetoothAdapter badapter = new BluetoothAdapter();
            badapter.setAddress(device.getAddress());
            adapter = badapter;
            /* Habilitar Bluetooth */
            if (!android.bluetooth.BluetoothAdapter.getDefaultAdapter().isEnabled()) {
                Intent bintent = new Intent(android.bluetooth.BluetoothAdapter.ACTION_REQUEST_ENABLE);
                startActivityForResult(bintent, REQUEST_ENABLE_BLUETOOTH);
            }
        }
        if (device.getType() == Type.Ethernet) {
            /* Dispositivo Ethernet */
            EthernetAdapter eadapter = new EthernetAdapter();
            eadapter.setAddress(device.getAddress());
            eadapter.setPort(Integer.parseInt(device.getPort()));
            adapter = eadapter;
            /** TODO Habilitar Ethernet */
        }

        /* Resultado */
        return adapter;
    }

    /*
     * Tratamento de Resultado sobre Intensões no Sistema
     */
    public void onActivityResult(int request, int result, Intent intent)
    {
        if (request == REQUEST_ENABLE_BLUETOOTH) {
            /* Requisição para Habilitar Bluetooth */
            if (result == RESULT_CANCELED) {
                /* Impossível Continuar sem Bluetooth */
                finish();
            }
        }
        if (request == REQUEST_ENABLE_ETHERNET) {
            /* Requisição para Habilitar Ethernet */
            if (result == RESULT_CANCELED) {
                /* Impossível Continuar sem Ethernet */
                finish();
            }
        }
    }

    /**
     * Atualiza a Camada de Visualização
     * Conforme Estado Atual do Cliente de Conexão
     * @param status Estado Atual do Cliente
     */
    public void updateUI(RemoteStatus status)
    {
        switch (status) {
        /* Tratamento do Estado do Cliente */
        case DISCONNECTED:
            /* Cliente Desconectado */
            left.setEnabled(false);
            right.setEnabled(false);
            dialog.dismiss();
            break;
        case CONNECTING:
            /* Tentativa de Conexão */
            left.setEnabled(false);
            right.setEnabled(false);
            dialog.show();
            break;
        case CONNECTED:
            /* Conexão Concluída */
            left.setEnabled(true);
            right.setEnabled(true);
            dialog.dismiss();
            break;
        case DISCONNECTING:
            /* Tentativa de Desconexão */
            left.setEnabled(false);
            right.setEnabled(false);
            dialog.dismiss();
        }
    }

    /**
     * Conexão do Cliente
     * Processamento Paralelo para Evitar Bloqueio de Interface do Usuário
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    private class PresenterConnector extends Thread
    {
        public void run()
        {
            try {
                /* Conexão com o Servidor */
                client.connect();
            } catch (RemoteException e) {
                /* Impossível Conectar ao Serviço */
                client.disconnect();
            }
        }
    }

    /**
     * Manipulador dos Estados do Cliente
     * 
     * Trabalha para configurações na visualização no fluxo principal de
     * execução, auxiliando na comunicação entre diferentes execuções
     *
     * @author Wanderson Henrique Camargo Rosa
     */
    private class PresenterHandler extends Handler implements Observer
    {
        /*
         * Manipulação da Visualização
         */
        public void handleMessage(Message msg)
        {
            if (msg.obj instanceof RemoteStatus) {
                RemoteStatus status = (RemoteStatus) msg.obj;
                updateUI(status);
            }
        }

        /*
         * Atualização do Observador
         */
        public void update(Observable obs, Object obj)
        {
            if (obs instanceof RemoteClient) {
                RemoteClient client = (RemoteClient) obs;
                Message msg = obtainMessage();
                msg.obj = client.getStatus();
                sendMessage(msg);
            }
        }
    }

    /**
     * Diálogo de Conexão
     * 
     * Exibição da Tentativa de Conexão do Cliente. Encapsulamento das
     * configurações necessárias para construção da caixa de diálogo. Deve ser
     * informado somente durante a tentativa de conexão. Cancelamento desconecta
     * o cliente de conexão.
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    private class PresenterDialog extends ProgressDialog
        implements DialogInterface.OnCancelListener
    {
        /**
         * Construtor
         * @param context Contexto de Utilização
         */
        public PresenterDialog()
        {
            super(PresenterActivity.this);
            setOnCancelListener(this);
        }

        /*
         * Cancelamento da Caixa de Diálogo
         */
        public void onCancel(DialogInterface dialog)
        {
            /** TODO Desconectar Cliente */
            /** TODO Problema: Temos que parar a Thread de Conexão */
        }
    }
}
