package br.nom.camargo.wanderson.btclient;

import java.io.IOException;
import java.io.OutputStream;
import java.util.Set;
import java.util.UUID;

import android.app.Activity;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class Main extends Activity {
    private final String uuid = "879c3537-ae66-4013-a677-9b7e5339d13c";
    private final String address  = "00:1B:10:00:4A:FE";
    private SystemOutClient client;
    private SystemOutConnection connection;
    private BluetoothSocket socket;
    private OutputStream out;
    private static final String TAG = "Bluetooth Client";
    private TextView message;

    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);

        client = new SystemOutClient();
        connection = new SystemOutConnection();

        Button send = (Button) findViewById(R.id.send);
        send.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                connection.run();
            }
        });
        message = (TextView) findViewById(R.id.message);

        client.run();
    }

    public void onDestroy()
    {
        super.onDestroy();
        if (out != null) {
            try {
                out.close();
            } catch (IOException e) {
                e.printStackTrace();
                Log.v(TAG, "Erro ao fechar o fluxo");
            }
        }
        if (socket != null) {
            try {
                socket.close();
            } catch (IOException e) {
                e.printStackTrace();
                Log.v(TAG, "Erro ao fechar conexão");
            }
        }
    }

    private class SystemOutClient extends Thread
    {
        public void run()
        {
            BluetoothAdapter adapter = BluetoothAdapter.getDefaultAdapter();
            if (adapter != null) {
                BluetoothDevice device = null;
                Set<BluetoothDevice> paired = adapter.getBondedDevices();
                for (BluetoothDevice d : paired) {
                    if (d.getAddress().equals(address)) {
                        device = d;
                    }
                }
                if (device != null) {
                    try {
                        socket = device.createRfcommSocketToServiceRecord(UUID.fromString(uuid));
                        socket.connect();
                        adapter.cancelDiscovery();
                        out = socket.getOutputStream();
                    } catch (IOException e) {
                        Log.v(TAG, "Erro ao Conectar");
                        e.printStackTrace();
                    }
                } else {
                    Log.v(TAG, "Dispositivo Não Encontrado");
                }
            }
        }
    }

    private class SystemOutConnection extends Thread
    {
        public void run()
        {
            if (out != null) {
                try {
                    byte buffer[] = message.getText().toString().getBytes();
                    out.write(buffer.length);
                    out.write(buffer);
                    Log.v(TAG, "Ok!");
                } catch (IOException e) {
                    Log.v(TAG, "Error!");
                    e.printStackTrace();
                }
            } else {
                Log.v(TAG, "Socket Null!");
            }
        }
    }
}