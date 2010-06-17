/**
 * 
 */
package machine;

import java.io.Console;

/**
 * Classe para entra e saida de dados da Machine
 * http://www.javalobby.org/java/forums/t84689.html
 * http://www.stupidjavatricks.com/?p=43
 * 
 * @author matiasoliveira
 * 
 */
public class Terminal {
	/**
	 * Máquina Configurada
	 */
	protected Machine machine;

	/**
	 * Console
	 */
	private Console con = System.console();

	/**
	 * Construtor
	 * 
	 * @param m
	 *            Machine
	 */
	public Terminal(Machine m) {
		this.machine = m;
	}

	/**
	 * Mostra mensagem na tela</br>"<b>> Mensagem<b/>"
	 * 
	 * @param m
	 *            Mensagem
	 */
	public void msgOut(String m) {
		if (con != null) {
			// con.writer().write("> " + m);
			con.printf("> %s", m);
		}
	}

	/**
	 * Mostra mensagem na tela</br>"<b>[Sender] Mensagem<b/>"
	 * 
	 * @param s
	 *            Sender
	 * @param m
	 *            Mensagem
	 */
	public void msgOut(String s, String m) {
		if (con != null) {
			con.printf("[%s] %s", s, m);
		}
	}

	/**
	 * Mostra requisição na tela</br>"<b>> Retorno<b/>"
	 * 
	 * @return Retorno da Requisição
	 */
	public String msgIn() {
		String temp = "";
		if (con != null) {
			temp = con.readLine("> ");
		}
		return temp;
	}

	/**
	 * Mostra requisição na tela</br>"<b>Texto > Retorno<b/>"
	 * 
	 * @param r
	 *            Requisição
	 * @return Retorno da Requisição
	 */
	public String msgIn(String r) {
		String temp = "";
		if (con != null) {
			temp = con.readLine("%s > ", r);
		}
		return temp;
	}

}
