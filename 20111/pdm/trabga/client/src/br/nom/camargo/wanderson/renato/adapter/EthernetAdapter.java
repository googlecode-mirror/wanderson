package br.nom.camargo.wanderson.renato.adapter;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.Socket;
import java.util.logging.Logger;

/**
 * Adaptador de Conexão Ethernet
 * 
 * Transferência de informações entre dispositivos remotos utilizando Ethernet.
 * Trabalha sobre o protocolo TCP/IP, criando um servidor de sockets. Extensão
 * do adaptador de comunicação do servidor de mensagens.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class EthernetAdapter extends ConnectionAdapter
{
    /**
     * Porta Padrão para Conexão
     */
    public static final int DEFAULT_PORT = 5000;

    /**
     * Elemento para Comunicação
     */
    private Socket socket;

    /**
     * Porta para Comunicação
     */
    private int port = DEFAULT_PORT;

    /**
     * Endereço para Conexão
     */
    private String address;

    /**
     * Configuração da Porta para Comunicação
     * @param port Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public EthernetAdapter setPort(int port)
    {
        this.port = port;
        return this;
    }

    /**
     * Informação da Porta para Comunicação
     * @return Elemento de Informação
     */
    public int getPort()
    {
        return port;
    }

    /**
     * Configuração da Porta para Comunicação
     * @param address Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public EthernetAdapter setAddress(String address)
    {
        this.address = address;
        return this;
    }

    /**
     * Informação da Porta para Comunicação
     * @return Elemento de Informação
     */
    public String getAddress()
    {
        return address;
    }

    public EthernetAdapter connect() throws ConnectionException
    {
        Logger l = Logger.getLogger("Renato_RemoteClient");
        /* Comunicação Física */
        Socket s = null;
        /* Fluxos de Dados */
        InputStream in   = null;
        OutputStream out = null;
        try {
            l.info("Adapter Ethernet Endereço: "
                + getAddress() + " Porta: " + getPort());
            s = new Socket(getAddress(), getPort());
            l.info("Conexão Aberta e Aceita");
            l.info("Abrindo Fluxos de Dados");
            /* Fluxos de Dados */
            in  = s.getInputStream();
            out = s.getOutputStream();
            /* Configuração do Comunicador */
            socket = s;
            /* Configuração dos Fluxos de Dados */
            setInputStream(in).setOutputStream(out);
        } catch (IOException e) {
            l.warning("Adapter Ethernet Erro na Abertura de Fluxos de Dados: " +
                e.getMessage());
            disconnect();
        }
        return this;
    }

    public ConnectionAdapter disconnect()
    {
        Logger l = Logger.getLogger("Renato_RemoteClient");
        try {
            l.info("Adapter Ethernet Finalizando Conexão");
            /* Finalizando Socket */
            if (socket != null) socket.close(); socket = null;
        } catch (IOException e) {
            l.warning("Adapter Ethernet Adapter Erro ao Finalizar a Conexão: "
                + e.getMessage());
        }
        setInputStream(null).setOutputStream(null);
        return this;
    }

    public boolean isConnected()
    {
        return socket != null;
    }
}
