package machine;

import java.io.ObjectOutputStream;
import java.net.*;

/**
 * Classe para Envio de Informação
 * Envia Pacotes para Outra Máquina na Rede
 * 
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Sender extends Interfacer
{
    /**
     * Endereço para Conexão
     */
    protected String address;

    /**
     * Construtor da Classe
     * @param machine Máquina Configurável
     */
    public Sender(Machine machine)
    {
        super(machine);
    }

    /**
     * Configuração do Endereço para Envio de Dados
     * @param address Endereço da Máquina Alvo
     * @return Próprio Objeto
     */
    public Sender setAddress(String address)
    {
        this.address = address;
        return this;
    }

    /**
     * Enfileiramento de Informações
     * @param element Elemento para Adição
     * @return Próprio Objeto
     */
    public Sender buffer(Pack element)
    {
        this.buffer.add(element);
        return this;
    }

    /**
     * Método Principal de Execução
     */
    public void run()
    {
        Pack element;
        Socket socket;
        ObjectOutputStream output;
        while (this.machine.isRunning()) {
            if (!this.buffer.isEmpty()) {
                element = this.buffer.poll();
                try {
                    socket = new Socket(this.address, 1000);
                    output = new ObjectOutputStream(socket.getOutputStream());
                    System.out.println("Sent: " + element);
                    output.writeObject(element);
                } catch (Exception e) {
                    this.machine.handler(e);
                }
            }
        }
    }

}
