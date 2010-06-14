package machine;

/**
 * ENum que contém os estatos possíveis de uma conexão.
 * 
 * @author matias oliveira
 * 
 */
public enum ConStatus {
	/**
	 * CONNECTING: Conexão Pronta ou em fase de conexão (handshake)
	 * CONNECTED: Conexão estabelecidade (Troca de dados)
	 * DISCONNECTING: Conexão em fase de desconexão (handshake)
	 */
	CONNECTING(0), CONNECTED(1), DISCONNECTING(2);
	/**
	 * Código de status da conexão
	 */
	private final int code;

	/**
	 * Retorna o código de status da conexão
	 * 
	 * @return Código de status da conexão
	 */
	public int getCode() {
		return code;
	}

	/**
	 * Construtor
	 * 
	 * @param code
	 *            Código do status da conexão
	 */
	private ConStatus(int code) {
		this.code = code;
	}
}
