package machine;

import java.io.ObjectOutputStream;
import java.net.*;

import mraeder.PackageTCP;

/**
 * Classe para Envio de Informação Envia Pacotes para Outra Máquina na Rede
 * 
 * @author Wanderson Henrique Camargo Rosa
 * 
 */
public class Sender extends Interfacer {
	/**
	 * Endereço para Conexão
	 */
	protected String address;

	/**
	 * Intervalo da última Janela enviada, contém o Número de Seqüencia do
	 * primeiro e último pacote da Janela
	 */
	protected int[] lastSendedWindow = new int[2];

	/**
	 * Último ACK recebido
	 */
	protected int lastAckReceived;

	/**
	 * Construtor da Classe
	 * 
	 * @param machine
	 *            Máquina Configurável
	 */
	public Sender(Machine machine) {
		super(machine);
	}

	/**
	 * Configuração do Endereço para Envio de Dados
	 * 
	 * @param address
	 *            Endereço da Máquina Alvo
	 * @return Próprio Objeto
	 */
	public Sender setAddress(String address) {
		this.address = address;
		return this;
	}

	/**
	 * Enfileiramento de Informações
	 * 
	 * @param element
	 *            Elemento para Adição
	 * @return Próprio Objeto
	 */
	public Sender buffer(PackageTCP element) {
		this.buffer.add(element);
		return this;
	}

	/**
	 * Retorna o intervalo de Número de Seqüencia da última Janela enviada
	 * 
	 * @return Intervalo da Janela
	 */
	public int[] getLastSendedWindow() {
		return this.lastSendedWindow;
	}

	/**
	 * Define o intervalo de Número de Seqüencia da última Janela enviada
	 * 
	 * @param first
	 *            Número de Seqüencia do primeiro pacote
	 * @param last
	 *            Número de Seqüencia do último pacote
	 * @throws Exception
	 *             Uma excessão é lançada quando o tamanho do intervalo definido
	 *             é diferente do tamanho da Janela de Envio
	 */
	public void setLastSendedWindow(int first, int last) throws Exception {
		if (last - first + 1 != this.getSenderWindowSize()) {
			throw new Exception(last - first + 1
					+ " is an invalid send window interval, valid: "
					+ this.getSenderWindowSize());
		}
		this.lastSendedWindow[0] = first;
		this.lastSendedWindow[1] = last;
	}

	/**
	 * Retorna o tamanho da Janela de Envio
	 * 
	 * @return Tamanho da Janela de Envio
	 */
	public int getSenderWindowSize() {
		return this.windowSize;
	}

	/**
	 * Define o tamanho da Janela de Envio
	 * 
	 * @param sendWindowSize
	 *            Tamanho da Janela de Envio
	 */
	public void setSenderWindowSize(int sendWindowSize) {
		this.windowSize = sendWindowSize;
	}

	/**
	 * Retorna o número do último ACK recebido
	 * 
	 * @return Número do último ACK recebido
	 */
	public int getLastAckReceived() {
		return this.lastAckReceived;
	}

	/**
	 * Define o número do último ACK recebido
	 * 
	 * @param lastAckReceived
	 *            Número do último ACK recebido
	 */
	public void setLastAckReceived(int lastAckReceived) {
		this.lastAckReceived = lastAckReceived;
	}

	/**
	 * Método Principal de Execução
	 */
	public void run() {
		PackageTCP element;
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
