package machine;

import java.io.*;

/**
 * Classe PacoteTCP para o Trabalho do Grau B
 * 
 * @author mraeder
 * 
 */
public class PacoteTCP implements Serializable {

	/**
	 * Número do Serializável
	 */
	private static final long serialVersionUID = 1847079612296169897L;

	/**
	 * Porta de Origem e Porta de Destino do pacote
	 */
	private String portaOrigem, portaDestino;

	/**
	 * Número de seqüencia do pacote, utilizado para o gerenciamento da ordem
	 * dos pacotes
	 */
	private int numSequencia;

	/**
	 * Número Ack, utilizado para a confirmação de pacotes
	 */
	private int numAck;

	/**
	 * ?
	 */
	private String tamanhoCabecalho;

	/**
	 * Espaço não utilizado do cabeçalho
	 */
	private String naoUsado;

	/**
	 * Flags do cabeçalho
	 */
	private int urg, ack, psh, rst, syn, fin;

	/**
	 * Tamanho da janela de envio, utilizado para informar o tamanho da janela
	 */
	private int tamanhoJanela;

	/**
	 * Checksum do pacote, calculado com o checksum setado em zero
	 */
	private String checksum;

	/**
	 * ?
	 */
	private String ponteiroUrgencia;

	/**
	 * Dados do pacote
	 */
	private String dados;

	/**
	 * Construtor
	 */
	public PacoteTCP() {
	}

	/**
	 * Define a Porta de Origem
	 * 
	 * @param portaOrigem
	 *            Porta de Origem
	 */
	public void setPortaOrigem(String portaOrigem) {
		this.portaOrigem = portaOrigem;
	}

	/**
	 * Define a Porta de Destino
	 * 
	 * @param portaDestino
	 *            Porta de Destino
	 */
	public void setPortaDestino(String portaDestino) {
		this.portaDestino = portaDestino;
	}

	/**
	 * Define o Número de Seqüencia
	 * 
	 * @param numSequencia
	 *            Número de Seqüencia
	 */
	public void setNumSequencia(int numSequencia) {
		this.numSequencia = numSequencia;
	}

	/**
	 * Define o Número do ACK
	 * 
	 * @param numAck
	 *            Número do ACK
	 */
	public void setNumAck(int numAck) {
		this.numAck = numAck;
	}

	/**
	 * Define o Tamanho do Cabeçalho
	 * 
	 * @param tamanhoCabecalho
	 *            Tamanho do Cabeçalho
	 */
	public void setTamanhoCabecalho(String tamanhoCabecalho) {
		this.tamanhoCabecalho = tamanhoCabecalho;
	}

	/**
	 * Insere dados no espaço não usado do cabeçalho
	 * 
	 * @param naoUsado
	 *            Dados
	 */
	public void setNaoUsado(String naoUsado) {
		this.naoUsado = naoUsado;
	}

	/**
	 * Define o valor da flag URG
	 * 
	 * @param urg
	 *            Valor (0/1)
	 */
	public void setUrg(int urg) {
		this.urg = urg;
	}

	/**
	 * Define o valor da flag ACK
	 * 
	 * @param ack
	 *            Valor (0/1)
	 */
	public void setAck(int ack) {
		this.ack = ack;
	}

	/**
	 * Define o valor da flag PSH
	 * 
	 * @param psh
	 *            Valor (0/1)
	 */
	public void setPsh(int psh) {
		this.psh = psh;
	}

	/**
	 * Define o valor da flag RST
	 * 
	 * @param rst
	 *            Valor (0/1)
	 */
	public void setRst(int rst) {
		this.rst = rst;
	}

	/**
	 * Define o valor da flag SYN
	 * 
	 * @param syn
	 *            Valor (0/1)
	 */
	public void setSyn(int syn) {
		this.syn = syn;
	}

	/**
	 * Define o valor da flag FIN
	 * 
	 * @param fin
	 *            Valor (0/1)
	 */
	public void setFin(int fin) {
		this.fin = fin;
	}

	/**
	 * Define o Tamanho da Janela
	 * 
	 * @param tamanhoJanela
	 *            Tamanho da Janela
	 */
	public void setTamanhoJanela(int tamanhoJanela) {
		this.tamanhoJanela = tamanhoJanela;
	}

	/**
	 * Define o Checksum do Pacote
	 * 
	 * @param checksum
	 *            Checksum
	 */
	public void setChecksum(String checksum) {
		this.checksum = checksum;
	}

	/**
	 * Define o Ponteiro de Urgência
	 * 
	 * @param ponteiroUrgencia
	 *            Ponteiro de Urgência
	 */
	public void setPonteiroUrgencia(String ponteiroUrgencia) {
		this.ponteiroUrgencia = ponteiroUrgencia;
	}

	/**
	 * Define os Dados do Pacote
	 * 
	 * @param dados
	 *            Dados do Pacote
	 */
	public void setDados(String dados) {
		this.dados = dados;
	}

	/**
	 * Retorna a Porta de Origem
	 * 
	 * @return Porta de Origem
	 */
	/**
	 * @return
	 */
	public String getPortaOrigem() {
		return this.portaOrigem;
	}

	/**
	 * Retorna a Porta de Destino
	 * 
	 * @return Porta de Destino
	 */
	public String getPortaDestino() {
		return this.portaDestino;
	}

	/**
	 * Retorna o Número de Seqüencia
	 * 
	 * @return Número de Seqüencia
	 */
	public int getNumSequencia() {
		return this.numSequencia;
	}

	/**
	 * Retorna o Número do ACK
	 * 
	 * @return Número do ACK
	 */
	public int getNumAck() {
		return this.numAck;
	}

	/**
	 * Retorna o Tamanho do Cabeçalho
	 * 
	 * @return Tamanho do Cabeçalho
	 */
	public String getTamanhoCabecalho() {
		return this.tamanhoCabecalho;
	}

	/**
	 * Retorna dados do espaço não usado do cabeçalho
	 * 
	 * @return Dados
	 */
	public String getNaoUsado() {
		return this.naoUsado;
	}

	/**
	 * Retorna o valor da flag URG
	 * 
	 * @return Flag URG
	 */
	public int getUrg() {
		return this.urg;
	}

	/**
	 * Retorna o valor da flag ACK
	 * 
	 * @return Flag ACK
	 */
	public int getAck() {
		return this.ack;
	}

	/**
	 * Retorna o valor da flag PSH
	 * 
	 * @return Flag PSH
	 */
	public int getPsh() {
		return this.psh;
	}

	/**
	 * Retorna o valor da flag RST
	 * 
	 * @return Flag RST
	 */
	public int getRst() {
		return this.rst;
	}

	/**
	 * Retorna o valor da flag SYN
	 * 
	 * @return Flag SYN
	 */
	public int getSyn() {
		return this.syn;
	}

	/**
	 * Retorna o valor da flag FIN
	 * 
	 * @return Flag FIN
	 */
	public int getFin() {
		return this.fin;
	}

	/**
	 * Retorna o Tamanho da Janela
	 * 
	 * @return Tamanho da Janela
	 */
	public int getTamanhoJanela() {
		return this.tamanhoJanela;
	}

	/**
	 * Retorna o Checksum do Pacote
	 * 
	 * @return Checksum do Pacote
	 */
	public String getChecksum() {
		return this.checksum;
	}

	/**
	 * Retorna o Ponteiro de Urgência
	 * 
	 * @return Ponteiro de Urgência
	 */
	public String getPonteiroUrgencia() {
		return this.ponteiroUrgencia;
	}

	/**
	 * Retorna os Dados do Pacote
	 * 
	 * @return Dados do Pacote
	 */
	public String getDados() {
		return this.dados;
	}

	/*
	 * (non-Javadoc)
	 * 
	 * @see java.lang.Object#toString()
	 */
	public String toString() {
		return "" + getPortaOrigem() + "" + getPortaDestino() + ""
				+ getNumSequencia() + "" + getNumAck() + ""
				+ getTamanhoCabecalho() + "" + getNaoUsado() + "" + getUrg()
				+ "" + getAck() + "" + getPsh() + "" + getRst() + "" + getSyn()
				+ "" + getFin() + "" + getTamanhoJanela() + ""
				+ "" + getPonteiroUrgencia() + "" + getDados() + "";
	}
}