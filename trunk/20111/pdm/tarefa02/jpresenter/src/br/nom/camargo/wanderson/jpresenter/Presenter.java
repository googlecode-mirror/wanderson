package br.nom.camargo.wanderson.jpresenter;

import javax.microedition.lcdui.Canvas;
import javax.microedition.lcdui.Command;
import javax.microedition.lcdui.CommandListener;
import javax.microedition.lcdui.Displayable;
import javax.microedition.lcdui.Graphics;
import javax.microedition.midlet.MIDlet;

/**
 * Apresentador
 * @author Wanderson Henrique Camargo Rosa
 */
public class Presenter extends Canvas implements CommandListener
{
	/**
	 * Objeto Principal de Execução
	 */
	private MIDlet main;

	/**
	 * Construtor Padrão
	 * @param main Objeto Principal de Execução
	 */
	public Presenter(MIDlet main)
	{
		this.setCommandListener(this);

		this.main = main;
		Command exit = new Command("Exit", Command.EXIT, 0);
		this.addCommand(exit);
	}

	/**
	 * Informação do Objeto Principal de Execução
	 * @return Elemento Solicitado
	 */
	public MIDlet getMain()
	{
		return this.main;
	}

	/**
	 * Renderização do Ambiente
	 */
	protected void paint(Graphics g)
	{
		g.setColor(255,255,255);
		g.fillRect(0, 0, this.getWidth(), this.getHeight());
	}

	/**
	 * Controle de Teclas
	 */
	protected void keyPressed(int keyCode)
	{
		
	}

	/**
	 * Manipulador de Comandos
	 */
	public void commandAction(Command c, Displayable d)
	{
		if (c.getCommandType() == Command.EXIT) {
			this.getMain().notifyDestroyed();
		}
	}

}
