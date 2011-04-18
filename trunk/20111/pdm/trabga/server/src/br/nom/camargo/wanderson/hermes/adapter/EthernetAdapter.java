package br.nom.camargo.wanderson.hermes.adapter;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.logging.Logger;

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
     * Serviço de Elementos para Comunicação
     */
    private ServerSocket sv;

    /**
     * Porta para Comunicação
     */
    private int port = DEFAULT_PORT;

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
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        /* Comunicação Física */
        Socket s = null;
        /* Fluxos de Dados */
        InputStream in   = null;
        OutputStream out = null;
        try {
            l.info("Adapter Ethernet Abrindo Porta " + getPort());
            sv = new ServerSocket(getPort());
            l.info("Adapter Ethernet Esperando Conexão de Dados");
            s  = sv.accept();
            l.info("Adapter Ethernet Conexão Aceita");
            l.info("Adapter Ethernet Abrindo Fluxos de Dados");
            /* Fluxos de Dados */
            in  = s.getInputStream();
            out = s.getOutputStream();
            /* Configuração do Comunicador */
            socket = s;
            /* Configuração de Fluxos */
            setInputStream(in).setOutputStream(out);
        } catch (IOException e) {
            l.warning("Adapter Ethernet Erro na Abertura de Fluxos de Dados: " +
                e.getMessage());
            disconnect();
        }
        return this;
    }

    public EthernetAdapter disconnect()
    {
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        try {
            l.info("Adapter Ethernet Finalizando Conexão");
            /* Finalizando Socket */
            if (socket != null) socket.close(); socket = null;
            /* Finalizando Serviço de Socket */
            if (sv != null) sv.close(); sv = null;
        } catch (IOException e) {
            l.warning("Adapter Ethernet Erro ao Finalizar a Conexão: " +
                e.getMessage());
        }
        setInputStream(null).setOutputStream(null);
        return this;
    }

    public boolean isConnected()
    {
        return socket != null;
    }
}
