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

	PackageTCP(String pOrigem, String pDestino) {
		super();
		this.setPortaOrigem(pOrigem);
		this.setPortaDestino(pDestino);
	}

	public PackageTCP(String pOrigem, String pDestino, int tJanela) {
		super();
		this.setPortaOrigem(pOrigem);
		this.setPortaDestino(pDestino);
		this.setTamanhoJanela(tJanela);
	}

}
