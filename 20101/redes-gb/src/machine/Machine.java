package machine;

import mraeder.PackageTCP;

/**
 * Classe Máquina Simulação de um Computador para Envio de Dados Através da Rede
 * 
 * @author Wanderson Henrique Camargo Rosa
 * 
 */
public class Machine {
	/**
	 * Estado de Execução
	 */
	protected boolean running;

	/**
	 * Estado da Conexão
	 */
	protected ConStatus connStatus;

	/**
	 * Envio de Informações
	 */
	protected Sender sender;

	/**
	 * Recebimento de Informações
	 */
	protected Receiver receiver;

	/**
	 * Terminal de Comunicação
	 */
	protected Terminal terminal;

	/**
	 * Construtor da Classe
	 */
	public Machine() {
		this.sender = new Sender(this);
		this.receiver = new Receiver(this);
		this.terminal = new Terminal(this);
	}

	/**
	 * Inicialização da Máquina
	 * 
	 * @return Próprio Objeto
	 */
	public Machine start() {
		this.running = true;
		this.setConStatus(ConStatus.CONNECTING);
		this.sender.start();
		this.receiver.start();
		return this;
	}

	/**
	 * Finalização da Máquina
	 * 
	 * @return Próprio Objeto
	 */
	public Machine stop() {
		this.running = false;
		this.sender.stop();
		this.receiver.stop();
		return this;
	}

	/**
	 * Configuração do Endereço para Envio
	 * 
	 * @param address
	 *            Endereço da Máquina Alvo
	 * @return Próprio Objeto
	 */
	public Machine setAddress(String address) {
		this.sender.setAddress(address);
		return this;
	}

	/**
	 * Informa o Estado da Máquina
	 * 
	 * @return Estado da Máquina
	 */
	public boolean isRunning() {
		return this.running;
	}

	/**
	 * Retorna o Estado da Conexão
	 * 
	 * @return Estado da Conexão
	 */
	public ConStatus conStatus() {
		return this.connStatus;
	}

	/**
	 * Define o Estado da Conexão
	 * 
	 * @param status
	 *            Estado da Conexão
	 */
	public void setConStatus(ConStatus status) {
		this.connStatus = status;
	}

	/**
	 * Envia Informações Enpacotadas para Máquina Destinatária
	 * 
	 * @param element
	 *            Elemento para Envio
	 * @return Próprio Objeto
	 */
	public Machine send(PackageTCP element) {
		this.sender.buffer(element);
		return this;
	}

	/**
	 * Retira Informações do Conjunto de Respostas
	 * 
	 * @return Pacotes Enviados
	 */
	public PackageTCP retrieve() {
		return this.receiver.unbuffer();
	}

	/**
	 * Manipulador de Erros
	 * 
	 * @param e
	 *            Erro Informado
	 * @return Próprio Objeto
	 */
	public Machine handler(Throwable e) {
		e.printStackTrace();
		return this;
	}
}
