package br.nom.camargo.wanderson.hermes.adapter;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.ServerSocket;
import java.net.Socket;

/**
 * Adaptador de Comunicação Ethernet
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
    private int port;

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
        return this.port;
    }

    public EthernetAdapter connect() throws ConnectionException
    {
        if (isConnected()) disconnect();
        /* Comunicação Física */
        Socket s        = null;
        ServerSocket sv = null;
        /* Fluxos de Dados */
        InputStream in   = null;
        OutputStream out = null;
        try {
            sv = new ServerSocket(getPort());
            s  = sv.accept();
            in  = s.getInputStream();
            out = s.getOutputStream();
            /* Configuração do Comunicador */
            socket = s;
            /* Configuração de Fluxos */
            setInputStream(in).setOutputStream(out);
        } catch (IOException e) {
            disconnect();
        }
        /* Fechar Serviço */
        try {
            if (sv != null) sv.close();
        } catch (IOException e) {}
        return this;
    }

    public EthernetAdapter disconnect()
    {
        try {
            if (isConnected()) socket.close();
        } catch (IOException e) {}
        setInputStream(null).setOutputStream(null);
        return this;
    }

    public boolean isConnected()
    {
        return socket != null;
    }
}
