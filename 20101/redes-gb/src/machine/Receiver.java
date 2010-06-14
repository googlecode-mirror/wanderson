package machine;

import java.io.*;
import java.net.*;
import java.util.NoSuchElementException;

/**
 * Classe de Recebimento Recebe Informações de Outra Máquina Local
 * 
 * @author Wanderson Henrique Camargo Rosa
 * 
 */
public class Receiver extends Interfacer {
	/**
	 * Serviço de Conexão
	 */
	protected ServerSocket server;

	/**
	 * Construtor da Classe
	 * 
	 * @param machine
	 *            Máquina Configurável
	 */
	public Receiver(Machine machine) {
		super(machine);
	}

	/**
	 * Retira Informações do Buffer
	 * 
	 * @return Elemento Enviado
	 */
	public Pack unbuffer() {
		return this.buffer.poll();
	}

	/**
	 * Retorna true se o pacote passado pode ser aceito
	 * 
	 * @param pkg
	 *            Pacote a validar
	 * @return
	 */
	public boolean isAcceptable(Pack pkg) {
		try {
			return pkg.getNumberSeq() == (this.buffer.getLast().getNumberSeq() + 1);
		} catch (NoSuchElementException e) {
			return true;
		}
	}

	/**
	 * Execução do Recebimento de Informações
	 */
	public void run() {
		Socket socket;
		Pack element;
		ObjectInputStream input;
		try {
			this.server = new ServerSocket(1000);
			while (this.machine.isRunning()) {
				socket = server.accept();
				input = new ObjectInputStream(socket.getInputStream());
				element = (Pack) input.readObject();
				System.out.println("Received: " + element);
				socket.close();
				if (this.machine.conStatus() == ConStatus.CONNECTING) {
					// IF SYN: Responde SYN+ACK
					// IF SYN+ACK: Responde ACK, Seta status para CONNECTED
					// IF ACK: Seta status para CONNECTED
				} else if (this.machine.conStatus() == ConStatus.CONNECTED) {
					// IF PACOTE: Processa Lógica e se for o caso responde ACK
					// IF ACK: Processa Lógica
					// IF FYN: Seta status para DISCONNECTING, Responde FYN+ACK
					//         (OBS: Máquina que enviou FYN já está em DISCONNECTING)
				} else if (this.machine.conStatus() == ConStatus.DISCONNECTING) {
					// IF FYN+ACK: Envia ACK, Reinicia a máquina, Status CONNECTING
					// IF ACK: Reinicia a máquina, Status CONNECTING

				}
				// if (!element.isAck()) {
				//
				// this.buffer.add(element);
				// int sequence = element.getNumberSeq();
				// element = new Pack(element.getContent().toUpperCase());
				// element.setAck(true).setNumberAck(sequence + 1);
				// this.machine.send(element);
				// System.out.println("Answer: " + element);
				// } else {
				// System.out.println("Answered: " + element);
				// }
			}
		} catch (Exception e) {
			this.machine.handler(e);
		}
	}

	/**
	 * Finalização do Serviço de Escuta
	 */
	public Receiver stop() {
		try {
			server.close();
		} catch (Exception e) {
			this.machine.handler(e);
		}
		super.stop();
		return this;
	}

}
