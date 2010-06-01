package receiver;

import java.io.*;
import java.net.*;
import java.util.*;
import br.unisinos.mraeder.*;

/**
 * Receiver Class
 * Classe Recebedora dos Pacotes TCP
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Receiver
{
    /**
     * Número do Último Pacote Recebido Corretamente
     */
    protected int sequence;

    /**
     * Buffer para Recebimento de Pacotes
     */
    protected Queue<PacoteTCP> buffer;

    /**
     * Servidor de Sockets para Conexão
     */
    protected ServerSocket server;

    /**
     * Socket Atual de Conexão
     */
    protected Socket socket;

    /**
     * Número da Porta de Recebimento de Pacotes
     */
    protected int port;

    /**
     * Tamanho da Janela
     */
    protected int size;

    public Receiver(int port)
    {
        this.setPort(port);
    }

    /**
     * Incrementa Número Sequencial de Pacotes
     * Adiciona uma unidade ao contador do último pacote correto
     * @return Próprio Objeto
     */
    public Receiver addSequenceNumber()
    {
        this.sequence = this.sequence + 1;
        return this;
    }

    /**
     * Retorna o Número Sequencial de Pacotes
     * Informa o valor de sequência do último pacote recebido corretamente
     * @return
     */
    public int getSequenceNumber()
    {
        return this.sequence;
    }

    /**
     * Configura o Número de Sequência
     * Modifica o número sequencial de pacotes atual
     * @param sequence Número Inicial da Sequência
     * @return Próprio Objeto
     */
    private Receiver setSequenceNumber(int sequence)
    {
        this.sequence = sequence;
        return this;
    }

    /**
     * Retorna o Buffer de Pacotes
     * Informa a lista de armazenamento de pacotes
     * @return Fila de Pacotes
     */
    public Queue<PacoteTCP> getBuffer()
    {
        return this.buffer;
    }

    /**
     * Configuração da Porta de Escuta
     * Informa o número da porta para recebimento de pacotes
     * @param port Número da Porta
     * @return Próprio Objeto
     */
    protected Receiver setPort(int port)
    {
        this.port = port;
        return this;
    }

    /**
     * Retorno do Número da Porta
     * Informa o valor numérico da porta configurada para conexão
     * @return Número da Porta
     */
    public int getPort()
    {
        return this.port;
    }

    /**
     * Configura o Tamanho da Janela
     * @param size Quantidade de elementos que devem ser recebidos
     * @return Próprio Objeto
     */
    public Receiver setWindowSize(int size)
    {
        this.size = size;
        return this;
    }

    /**
     * Retorna o Valor do Tamanho da Janela
     * @return Informa a quantidade de elementos que podem ser recebidos
     */
    public int getWindowSize()
    {
        return this.size;
    }

    /**
     * Inicialização do Serviço de Recebimento de Pacotes
     */
    public void start()
    {
        try {

            this.server = new ServerSocket(this.getPort());
            boolean running = true;

            while (running) {

                this.socket = this.server.accept();
                ObjectInputStream input
                    = new ObjectInputStream(this.socket.getInputStream());
                PacoteTCP pacote = (PacoteTCP) input.readObject();

                if (pacote.getSyn() == 1) {

                    this
                        .setSequenceNumber(pacote.getNumSequencia())
                        .addSequenceNumber()
                        .setWindowSize(pacote.getTamanhoJanela());

                    /**
                     * @todo Organizar Leitura
                     */

                }

            }

        } catch (IOException e) {
            
        } catch (ClassNotFoundException e) {
            
        }
    }

    /**
     * Recebe a Janela de Conexão
     * Efetua leitura de uma determinada quantidade de elementos do cliente
     * @return Self Object
     */
    public Receiver getWindow()
    {
        /**
         * @todo Criar Leitura de Janela
         */
        return this;
    }
}
