package br.nom.camargo.wanderson.renato.adapter;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.UUID;

import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.util.Log;

/**
 * Adaptador de Conexão Bluetooth
 * 
 * Transferência de informações entre dispositivos remotos utilizando Bluetooth.
 * Trabalha sobre o protocolo BTSPP, criando um servidor notificável. Extensão
 * do adaptador de conexão do servidor de mensagens.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class BluetoothAdapter extends ConnectionAdapter
{
    /**
     * Identificador Único de Conexão
     */
    private static final String uuid = "879c3537-ae66-4013-a677-9b7e5339d13c";

    /**
     * Endereço para Conexão
     */
    private String address;

    /**
     * Comunicador
     */
    private BluetoothSocket socket;

    /**
     * Informa o Identificador Único de Conexão
     * @return Elemento de Informação
     */
    public String getUUID()
    {
        return uuid;
    }

    /**
     * Configura o Endereço para Conexão
     * @param address Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public BluetoothAdapter setAddress(String address)
    {
        this.address = address;
        return this;
    }

    /**
     * Informa o Endereço para Conexão
     * @return Elemento de Informação
     */
    public String getAddress()
    {
        return address;
    }

    public BluetoothAdapter connect() throws ConnectionException
    {
        Log.i(TAG, "Inicializando Conexão Bluetooth");
        /* Pesquisa do Dispositivo */
        String address = getAddress();
        android.bluetooth.BluetoothAdapter adapter =
            android.bluetooth.BluetoothAdapter.getDefaultAdapter();
        /* Bluetooth Não Habilitado */
        if (!adapter.isEnabled()) {
            throw new ConnectionException("Enable Bluetooth");
        }
        /* Captura do Dispositivo */
        BluetoothDevice device = null;
        for (BluetoothDevice d : adapter.getBondedDevices()) {
            if (address.equals(d.getAddress())) {
                device = d;
            }
        }
        /* Verificação de Encontro */
        if (device == null) {
            throw new ConnectionException("Invalid Address");
        }
        /* Comunicação Física */
        BluetoothSocket s = null;
        /* Fluxos de Dados */
        InputStream in   = null;
        OutputStream out = null;
        try {
            Log.i(TAG, "Adapter Bluetooth Endereço: " + getAddress() +
                ", UUID: " + getUUID());
            s = device
                .createRfcommSocketToServiceRecord(UUID.fromString(getUUID()));
            s.connect();
            Log.i(TAG, "Conexão Aberta e Aceita");
            Log.i(TAG, "Abrindo Fluxos de Dados");
            /* Fluxos de Dados */
            in  = s.getInputStream();
            out = s.getOutputStream();
            /* Configuração do Comunicador */
            socket = s;
            /* Configuração dos Fluxos de Dados */
            setInputStream(in).setOutputStream(out);
        } catch (IOException e) {
            Log.w(TAG, "Adapter Bluetooth Erro na Abertura de Fluxos de Dados "
                + e.getMessage());
            e.printStackTrace();
            disconnect();
        }
        return this;
    }

    public BluetoothAdapter disconnect()
    {
        try {
            Log.i(TAG, "Adapter Bluetooth Finalizando Conexão");
            /* Finalizando Socket */
            if (socket != null) socket.close();
        } catch (IOException e) {
            Log.w(TAG, "Adapter Bluetooth Erro ao Finalizar Conexão "
                + e.getMessage());
        }
        socket = null;
        setInputStream(null).setOutputStream(null);
        return this;
    }

    public boolean isConnected()
    {
        return socket != null;
    }

}
