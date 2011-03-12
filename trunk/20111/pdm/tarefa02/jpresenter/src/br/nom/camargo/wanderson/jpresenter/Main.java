package br.nom.camargo.wanderson.jpresenter;

import javax.microedition.lcdui.Display;
import javax.microedition.midlet.MIDlet;

/**
 * Classe Principal de Execução
 * Inicialização do MIDlet
 * @author Wanderson Henrique Camargo Rosa
 */
public class Main extends MIDlet
{
	/**
	 * Controle do Apresentador
	 */
	private Presenter presenter;

	/**
	 * Construtor Padrão
	 */
	public Main()
	{
		presenter = new Presenter(this);
		Display.getDisplay(this).setCurrent(presenter);
	}

	/**
	 * Informa o Apresentador
	 * @return Objeto Solicitado
	 */
	public Presenter getPresenter()
	{
		return this.presenter;
	}

	/**
	 * Ciclo de Vida do MIDlet
	 * Tempo de Inicialização do Aplicativo
	 */
	protected void startApp()
	{
		
	}

	/**
	 * Ciclo de Vida do MIDlet
	 * Tempo de Parada do Aplicativo
	 */
	protected void pauseApp()
	{
		
	}

	/**
	 * Ciclo de Vida do MIDlet
	 * Tempo de Destruição do Aplicativo
	 */
	protected void destroyApp(boolean unconditional)
	{
		this.notifyDestroyed();
	}

}
