/**
 * 
 */
package mraeder;

/**
 * PackageTCP - Classe de envio de dados Implementação da classe PacoteTCP,
 * contem todos os métodos e atributos originais e mais alguns métodos
 * auxiliares
 * 
 * @author matiasoliveira
 * 
 */
public class PackageTCP extends PacoteTCP {

	/**
	 * Número do Serializável
	 */
	private static final long serialVersionUID = 7668748386543441076L;

	/**
	 * Construtor
	 */
	public PackageTCP() {
		super();
	}

	/**
	 * Construtor
	 * 
	 * @param content
	 *            Conteúdo
	 */
	public PackageTCP(String content) {
		super();
		this.setDados(content);
	}

	/**
	 * Construtor
	 * 
	 * @param pOrigem
	 *            Porta de Origem
	 * @param pDestino
	 *            Porta de Destino
	 */
	public PackageTCP(String pOrigem, String pDestino) {
		super();
		this.setPortaOrigem(pOrigem);
		this.setPortaDestino(pDestino);
	}

	/**
	 * Construtor
	 * 
	 * @param pOrigem
	 *            Porta de Origem
	 * @param pDestino
	 *            Porta de Destino
	 * @param tJanela
	 *            Tamanho da Janela
	 */
	public PackageTCP(String pOrigem, String pDestino, int tJanela) {
		super();
		this.setPortaOrigem(pOrigem);
		this.setPortaDestino(pDestino);
		this.setTamanhoJanela(tJanela);
	}

	/**
	 * Flag URG definida?
	 * 
	 * @return true/false
	 */
	public boolean isUrg() {
		return this.getUrg() == 1;
	}

	/**
	 * Flag PSH definida?
	 * 
	 * @return true/false
	 */
	public boolean isPsh() {
		return this.getPsh() == 1;
	}

	/**
	 * Flag RST definida?
	 * 
	 * @return true/false
	 */
	public boolean isRst() {
		return this.getRst() == 1;
	}

	/**
	 * É um Pacote de Dados?
	 * 
	 * @return true/false
	 */
	public boolean isPackage() {
		return (!this.isAck() && !this.isFin() && !this.isSyn());
	}

	/**
	 * Flag ACK definida?
	 * 
	 * @return true/false
	 */
	public boolean isAck() {
		return this.getAck() == 1;
	}

	/**
	 * Flag SYN definida?
	 * 
	 * @return true/false
	 */
	public boolean isSyn() {
		return this.getSyn() == 1;
	}

	/**
	 * Flag FIN definida?
	 * 
	 * @return true/false
	 */
	public boolean isFin() {
		return this.getFin() == 1;
	}

}
