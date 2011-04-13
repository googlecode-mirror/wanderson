package br.nom.camargo.wanderson.hermes.adapter;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import javax.microedition.io.Connector;
import javax.microedition.io.StreamConnection;
import javax.microedition.io.StreamConnectionNotifier;

/**
 * Adaptador de Comunicação Bluetooth
 * 
 * Transferência de informações entre dispositivos remotos utilizando Bluetooth.
 * Trabalha sobre o protocolo Bluetooth Serial Port Profile. Abre uma conexão
 * utilizando um UUID específico da aplicação. Utiliza API externa ao Java.
 * Extensão do adaptador de comunicação do servidor de mensagens.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class BluetoothAdapter extends ConnectionAdapter
{
    /**
     * Identificador Único de Conexão
     */
    private final String uuid = "879c3537-ae66-4013-a677-9b7e5339d13c";

    /**
     * Elemento para Comunicação
     */
    private StreamConnection stream;

    /**
     * Padronização do Identificador Único para API
     * @return Valor Filtrado Conforme Necessidades
     */
    public String getUUID()
    {
        return uuid.replace("-", "");
    }

    public BluetoothAdapter connect() throws ConnectionException
    {
        /* Endereço de Conexão */
        String addr = "btspp://localhost:" + getUUID();
        /* Conexão Física */
        StreamConnectionNotifier n = null;
        StreamConnection s         = null;
        /* Fluxos de Dados */
        InputStream in   = null;
        OutputStream out = null;
        try {
            n = (StreamConnectionNotifier) Connector.open(addr);
            s = n.acceptAndOpen();
            in  = s.openInputStream();
            out = s.openOutputStream();
            /* Configuração do Comunicador */
            stream = s;
            /* Configuração de Fluxos */
            setInputStream(in).setOutputStream(out);
        } catch (IOException e) {
            disconnect();
        }
        /* Fechar Serviço */
        try {
            if (n != null) n.close();
        } catch (IOException e) {}
        return this;
    }

    public BluetoothAdapter disconnect()
    {
        try {
            if (stream != null) stream.close();
        } catch (IOException e) {}
        setInputStream(null).setOutputStream(null);
        return this;
    }

    public boolean isConnected()
    {
        return stream != null;
    }
}
