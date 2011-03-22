package br.nom.camargo.wanderson.testserver;

import java.io.IOException;
import java.io.InputStream;
import java.net.ServerSocket;
import java.net.Socket;

/**
 * Servidor de Sockets com Leitura Binária
 * @author Wanderson Henrique Camargo Rosa
 */
public class TestServer
{
    /**
     * Porta Padrão para Conexão
     */
    public static final int DEFAULT_PORT = 5000;

    /**
     * Servidor de Sockets
     */
    private ServerSocket server;

    /**
     * Conexão Individual
     */
    private Socket socket;

    /**
     * Confirmação de Execução
     */
    private boolean running;

    /**
     * Construtor Padrão da Classe
     */
    public TestServer()
    {
        this.server = null;
        this.socket = null;
        this.running = false;
    }

    /**
     * Inicialização do Serviço
     * @return Próprio Objeto para Encadeamento
     * @throws TestServerException Erro Interno Encontrado
     */
    public TestServer start() throws TestServerException
    {
        if (server == null) {
            try {
                server = new ServerSocket(TestServer.DEFAULT_PORT);
                running = true;
            } catch (IOException e) {
                throw new TestServerException(e);
            }
        }
        while (running) {
            try {
                socket = server.accept();
                InputStream in = socket.getInputStream();
                int size = in.read();
                byte buffer[] = new byte[size];
                in.read(buffer);
                System.out.println(new String(buffer));
                socket.close();
                socket = null;
            } catch (IOException e) {
                throw new TestServerException(e);
            }
        }
        try {
            server.close();
        } catch (IOException e) {
            throw new TestServerException(e);
        }
        return this;
    }
}
