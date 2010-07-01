package machine;

import java.io.*;
import java.net.*;
import java.util.*;

/**
 * Classe Máquina
 * Simulador de Envio e Recebimento de Pacotes
 * @author Wanderson Henrique Camargo Rosa
 * @author Matias Oliveira
 *
 */
public abstract class Machine implements Runnable
{
    /**
     * Socket para Conexão das Máquinas
     */
    protected Socket socket;

    /**
     * 
     */
    protected ObjectOutputStream output;

    /**
     * 
     */
    protected ObjectInputStream input;

    /**
     * Buffer para Envio
     */
    protected LinkedList<PacoteTCP> buffer;

    /**
     * Lista de Pacotes para Forçar Erros
     */
    protected LinkedList<PacoteTCP> errors;

    /**
     * Construtor
     */
    public Machine() throws Exception
    {
        this.buffer = new LinkedList<PacoteTCP>();
        this.errors = new LinkedList<PacoteTCP>();
    }

    /**
     * Inicialização do Socket
     * @return Próprio Objeto
     */
    public abstract Machine init() throws Exception;

    /**
     * Fluxo de Execução
     */
    public void run()
    {
        while (true) {
            try {
                this.receiveBuffer();
            } catch (Exception e) {
                e.printStackTrace();
                System.exit(0);
            }
        }
    }

    /**
     * Inicialização da Máquina
     * @return Próprio Objeto
     */
    public Machine start(String type) throws Exception
    {
        if (type.equals("server")) {
            this.receiveBuffer();
        } else if (type.equals("client")) {
            this.sendBuffer();
        }
        return this;
    }

    /**
     * Enfileiramento de Pacotes para Envio
     * @param content Conteúdo do Pacote
     * @return Próprio Objeto
     */
    public Machine buffer(String content)
    {
        PacoteTCP element = new PacoteTCP();
        element.setDados(content);
        this.buffer.add(element);
        return this;
    }

    public Machine forceError(int index)
    {
        errors.add(buffer.get(index));
        return this;
    }

    /**
     * Envia os Pacotes Enfileirados
     * @return Próprio Objeto
     * @throws Exception Erros Diversos
     */
    public Machine sendBuffer() throws Exception
    {
        int size = 4;
        int sequence = 0;
        output = new ObjectOutputStream(socket.getOutputStream());
        input  = new ObjectInputStream(socket.getInputStream());
        PacoteTCP element, answer;

        /*
         * Abrir Conexão
         */
        element = new PacoteTCP();
        element.setSyn(1);
        element.setNumSequencia(sequence);
        element.setTamanhoJanela(size);
        output.writeObject(element);
        answer = (PacoteTCP) input.readObject();

        if (!(answer != null && answer.getAck() == 1 && answer.getNumAck() == sequence + 1)) {
            throw new Exception("Conexão Negada");
        }

        /*
         * Conexão Estabelecida
         */
        sequence = sequence + 1;
        

        while (sequence - 1 < buffer.size()) {
            /*
             * Envio de Janela
             */
            int i;
            for (i = sequence; i < sequence + size && i <= buffer.size(); i++) {
                buffer.get(i-1).setNumSequencia(i);
                PseudoHeader.recordChecksum(buffer.get(i-1));
                System.out.printf("Enviado > %s\n", buffer.get(i-1).getNumSequencia());
//                if (errors.indexOf(buffer.get(i-1)) != -1) {
//                    buffer.get(i-1).setChecksum("0000000000000000");
//                    errors.remove(buffer.get(i-1));
//                }
                element = buffer.get(i-1);
                System.out.printf("Checksum > %s\n", buffer.get(i-1).getChecksum());
                output.writeObject(buffer.get(i-1));
            }
            System.out.println("---");
            if (i - 1 == buffer.size()) {
                sequence = i;
                break;
            }
            /*
             * Recebimento de Resposta
             */
            answer = (PacoteTCP) input.readObject();
            if (answer != null && answer.getAck() == 1) {
                sequence = answer.getNumAck();
            }
        }

        /*
         * Fechar Conexão
         */
        element = new PacoteTCP();
        element.setFin(1);
        element.setNumSequencia(sequence);
        output.writeObject(element);
        answer = (PacoteTCP) input.readObject();
        if (!(answer != null && answer.getAck() == 1 && answer.getNumAck() == sequence + 1)) {
            throw new Exception("Conexão Negada");
        }

        input.close();
        output.close();
        buffer.clear();

        return this;
    }

    /**
     * Recebe Pacotes
     * @return Próprio Objeto
     * @throws Exception Erros Diversos
     */
    public Machine receiveBuffer() throws Exception
    {
        int size;
        int sequence;
        output = new ObjectOutputStream(socket.getOutputStream());
        input  = new ObjectInputStream(socket.getInputStream());
        PacoteTCP element, answer;

        /*
         * Abrir Conexão
         */
        element = (PacoteTCP) input.readObject();
        if (!(element != null && element.getSyn() == 1)) {
            throw new Exception("Conexão Negada");
        }
        size = element.getTamanhoJanela();
        sequence = element.getNumSequencia() +1;
        answer = new PacoteTCP();
        answer.setAck(1);
        answer.setNumAck(sequence);
        output.writeObject(answer);

        /*
         * Conexão Estabelecida
         */
        int counter = size;
        while ((element = (PacoteTCP) input.readObject()) != null && element.getFin() != 1) {
            System.out.printf("Recebido > %s\n", element.getNumSequencia());
            System.out.printf("Sequence > %d\n", sequence);
            System.out.printf("Checksum > %s\n", element.getChecksum());
            if (element.getNumSequencia() == sequence && PseudoHeader.checksum(element)) {
                sequence = sequence + 1;
            }
            counter = counter - 1;
            if (counter == 0) {
                counter = size;
                answer = new PacoteTCP();
                answer.setAck(1);
                answer.setNumAck(sequence);
                output.writeObject(answer);
                System.out.println("---");
            }
        }

        /*
         * Fechar Conexão
         */
        sequence = sequence + 1;
        answer = new PacoteTCP();
        answer.setAck(1);
        answer.setNumAck(sequence);
        output.writeObject(answer);

        input.close();
        output.close();

        return this;
    }
}
