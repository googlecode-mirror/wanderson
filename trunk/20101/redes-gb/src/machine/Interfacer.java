package machine;

import java.util.LinkedList;

import mraeder.PackageTCP;

/**
 * Classe Intermediadora Simulação de Interface de Rede
 * 
 * @author Wanderson Henrique Camargo Rosa
 * 
 */
public abstract class Interfacer implements Runnable {
	/**
	 * Máquina Configurada
	 */
	protected Machine machine;

	/**
	 * Fluxo de Processamento
	 */
	protected Thread thread;

	/**
	 * Fila de Processamento
	 */
	protected LinkedList<PackageTCP> buffer;

	/**
	 * Janela de Envio/Recebimento, padrão 1
	 */
	protected int windowSize;

	/**
	 * Construtor da Classe
	 * 
	 * @param machine
	 *            Máquina Configurável
	 */
	public Interfacer(Machine machine) {
		this.machine = machine;
		this.buffer = new LinkedList<PackageTCP>();
		this.thread = new Thread(this);
		this.windowSize = 1;
	}

	/**
	 * Inicialização do Fluxo Executável
	 * 
	 * @return Próprio Objeto
	 */
	public Interfacer start() {
		this.thread.start();
		return this;
	}

	/**
	 * Finalização do Fluxo Executável
	 * 
	 * @return Próprio Objeto
	 */
	public Interfacer stop() {
		return this;
	}

	/**
	 * Abstração de Execução da Classe
	 */
	public abstract void run();
}
