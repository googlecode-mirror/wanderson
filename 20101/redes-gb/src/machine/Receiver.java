package machine;

import java.io.*;
import java.net.*;
import java.util.NoSuchElementException;

import mraeder.PackageTCP;

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
	public PackageTCP unbuffer() {
		return this.buffer.poll();
	}

	/**
	 * Retorna true se o pacote passado pode ser aceito
	 * 
	 * @param pkg
	 *            Pacote a validar
	 * @return
	 */
	public boolean isAcceptable(PackageTCP pkg) {
		try {
			return pkg.getNumSequencia() == (this.buffer.getLast()
					.getNumSequencia() + 1);
		} catch (NoSuchElementException e) {
			return true;
		}
	}

	/**
	 * Retorna o tamanho da Janela de Recebimento
	 * 
	 * @return Tamanho da Janela de Recebimento
	 */
	public int getReceiverWindowSize() {
		return this.windowSize;
	}

	/**
	 * Define o tamanho da Janela de Recebimento
	 * 
	 * @param sendWindowSize
	 *            Tamanho da Janela de Recebimento
	 */
	public void setReceiverWindowSize(int receiveWindowSize) {
		this.windowSize = receiveWindowSize;
	}

	/**
	 * Execução do Recebimento de Informações
	 */
	public void run() {
		Socket socket;
		PackageTCP element;
		ObjectInputStream input;
		try {
			this.server = new ServerSocket(1000);
			while (this.machine.isRunning()) {
				socket = server.accept();
				input = new ObjectInputStream(socket.getInputStream());
				element = (PackageTCP) input.readObject();
				System.out.println("Received: " + element);
				socket.close();
				/*
				 * Tratamento de pacotes, máquina CONNECTING
				 */
				if (this.machine.conStatus() == ConStatus.CONNECTING) {
					/*
					 * IF SYN+ACK: Responde ACK, Seta status para CONNECTED
					 * Ocorre no Cliente A
					 */
					if (element.isSyn() && element.isAck()) {
						// Envia ACK em resposta ao SYN+ACK (Wanderson,
						// conferir)
						this.machine.terminal.msgOut("Receiver",
								"Recebido SYN+ACK.");
						PackageTCP resposta = new PackageTCP();
						resposta.setAck(1);
						this.machine.send(resposta);
						this.machine.terminal.msgOut("Receiver",
								"Respondido ACK.");
						this.machine.setConStatus(ConStatus.CONNECTED);
						this.machine.terminal.msgOut("Receiver", "Conectado");
					}
					/*
					 * IF SYN: Responde SYN+ACK Ocorre no Cliente B
					 */
					else if (element.isSyn() && !element.isAck()) {
						// Envia SYN+ACK em resposta ao SYN (Wanderson,
						// conferir)
						this.machine.terminal.msgOut("Receiver", "Conectando.");
						this.machine.terminal.msgOut("Receiver",
								"Recebido SYN.");
						PackageTCP resposta = new PackageTCP();
						resposta.setAck(1);
						resposta.setSyn(1);
						this.machine.send(resposta);
						this.machine.terminal.msgOut("Receiver",
								"Respondido SYN+ACK.");
					}
					/*
					 * IF ACK: Seta tamanho da janela, Seta status para
					 * CONNECTED Ocorre no Cliente B
					 */
					else if (element.isAck() && !element.isSyn()) {
						// Define Tamanho da Janela (Wanderson,
						// conferir)
						this.machine.terminal.msgOut("Receiver",
								"Recebido ACK.");
						this.setReceiverWindowSize(element.getTamanhoJanela());
						this.machine.terminal.msgOut("Receiver",
								"Tamanho da Janela definida para "
										+ this.getReceiverWindowSize() + ".");
						this.machine.setConStatus(ConStatus.CONNECTED);
						this.machine.terminal.msgOut("Receiver", "Conectado");
					}
					/*
					 * EXCESSÕES
					 */
					else {
						// Mostrar mensagem de pacote descartado por ser
						// inválido?
						this.machine.terminal.msgOut("Receiver",
								"Mensagem inválida, descartada.");
					}
				}
				/*
				 * Tratamento de pacotes, máquina CONNECTED
				 */
				else if (this.machine.conStatus() == ConStatus.CONNECTED) {
					/*
					 * IF FYN: Seta status para DISCONNECTING, Responde FYN+ACK
					 * (OBS: Máquina que enviou FYN já está em DISCONNECTING)
					 * Ocorre no Cliente B
					 */
					if (element.isFin()) {
						// Envia FYN+ACK em resposta ao FYN (Wanderson,
						// conferir)
						this.machine.setConStatus(ConStatus.DISCONNECTING);
						this.machine.terminal.msgOut("Receiver",
								"Desconectando.");
						this.machine.terminal.msgOut("Receiver",
								"Recebido FIN.");
						PackageTCP resposta = new PackageTCP();
						resposta.setFin(1);
						resposta.setAck(1);
						this.machine.send(resposta);
						this.machine.terminal.msgOut("Receiver",
								"Respondido FIN+ACK.");
					}
					/*
					 * IF ACK: Processa Lógica, Confirmação Ocorre no Cliente A
					 */
					else if (element.isAck()) {
						this.machine.sender
								.setLastAckReceived(element.getAck());
						// TODO: Tratamento de recebimento de ACK (Envia próxima
						// janela)
					}
					/*
					 * IF PACOTE: Processa Lógica e se for o caso responde ACK
					 * Ocorre no Cliente B
					 */
					else if (!element.isAck()) {
						// TODO: Recebimento de pacote, tratamento de janela
					}
					/*
					 * EXCESSÕES
					 */
					else {
						// Mostrar mensagem de pacote descartado por ser
						// inválido?
						this.machine.terminal.msgOut("Receiver",
								"Mensagem inválida, descartada.");
					}
				}
				/*
				 * Tratamento de pacotes, máquina DISCONNECTING
				 */
				else if (this.machine.conStatus() == ConStatus.DISCONNECTING) {
					/*
					 * IF FYN+ACK: Envia ACK, Reinicia a máquina, Status
					 * CONNECTING (Já está em DISCONNECTING de quando enviou o
					 * FYN) Ocorre no Cliente A
					 */
					if (element.isFin() && element.isAck()) {
						// Reinicia a máquina, "Desconeta" (Wanderson,
						// conferir)
						this.machine.terminal.msgOut("Receiver",
								"Recebido FIN+ACK.");
						PackageTCP resposta = new PackageTCP();
						resposta.setAck(1);
						this.machine.send(resposta);
						this.machine.terminal.msgOut("Receiver",
								"Respondido ACK.");
						this.machine.setConStatus(ConStatus.CONNECTING);
						this.machine.terminal
								.msgOut("Receiver", "Desconectado");

					}
					/*
					 * IF ACK: Reinicia a máquina, Status CONNECTINGOcorre no
					 * Cliente B
					 */
					else if (element.isAck() && !element.isFin()) {
						// Reinicia a máquina, "Desconeta" (Wanderson,
						// conferir)
						this.machine.terminal.msgOut("Receiver",
								"Recebido ACK.");
						this.machine.setConStatus(ConStatus.DISCONNECTING);
						this.machine.terminal
								.msgOut("Receiver", "Desconectado");
					}
					/*
					 * EXCESSÕES
					 */
					else {
						// Mostrar mensagem de pacote descartado por ser
						// inválido?
						this.machine.terminal.msgOut("Receiver",
								"Mensagem inválida, descartada.");
					}
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
