package br.nom.camargo.wanderson.hermes.adapter;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.logging.Logger;

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
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        /* Endereço de Conexão */
        String addr = "btspp://localhost:" + getUUID();
        /* Conexão Física */
        StreamConnectionNotifier n = null;
        StreamConnection s         = null;
        /* Fluxos de Dados */
        InputStream in   = null;
        OutputStream out = null;
        try {
            l.info("Adapter Bluetooth Abrindo Porta " + getUUID());
            n = (StreamConnectionNotifier) Connector.open(addr);
            l.info("Adapter Bluetooth Esperando Conexão de Dados");
            s = n.acceptAndOpen();
            l.info("Adapter Bluetooth Conexão Aceita");
            l.info("Adapter Bluetooth Abrindo Fluxos de Dados");
            /* Fluxos de Dados */
            in  = s.openInputStream();
            out = s.openOutputStream();
            /* Configuração do Comunicador */
            stream = s;
            /* Configuração de Fluxos */
            setInputStream(in).setOutputStream(out);
        } catch (IOException e) {
            l.warning("Adapter Bluetooth Erro na Abertura de Fluxos de Dados: "+
                e.getMessage());
            disconnect();
        }
        /* Fechar Serviço */
        try {
            l.info("Adapter Bluetooth Finalizando Servidor de Conexões");
            if (n != null) n.close();
        } catch (IOException e) {
            l.warning("Adapter Bluetooth Erro ao Finalizar a Conexão: " +
                e.getMessage());
        }
        return this;
    }

    public BluetoothAdapter disconnect()
    {
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        try {
            l.info("Adapter Bluetooth Finalizando Conexão");
            if (stream != null) stream.close();
        } catch (IOException e) {
            l.warning("Adapter Bluetooth Erro ao Finalizar a Conexão: " +
                e.getMessage());
        }
        setInputStream(null).setOutputStream(null);
        return this;
    }

    public boolean isConnected()
    {
        return stream != null;
    }
}
