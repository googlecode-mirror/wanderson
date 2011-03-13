package br.nom.camargo.wanderson.jdrawme;

import javax.microedition.lcdui.Command;
import javax.microedition.lcdui.CommandListener;
import javax.microedition.lcdui.Display;
import javax.microedition.lcdui.Displayable;
import javax.microedition.midlet.MIDlet;

/**
 * Classe Principal de Execução
 * @author Wanderson Henrique Camargo Rosa
 */
public class Main extends MIDlet implements CommandListener
{
	/**
	 * Comando para Saída do Aplicativo
	 */
	private Command exit;

	/**
	 * Construtor da Classe
	 */
	public Main()
	{
		Drawer d = new Drawer();
		Display.getDisplay(this).setCurrent(d);
		/* Comandos */
		exit = new Command("Exit", Command.EXIT, 0);
		d.addCommand(exit);
		d.setCommandListener(this);
	}

	/**
	 * Ciclo de Vida do Aplicativo
	 * Tempo de Inicialização
	 */
	public void startApp() {}

	/**
	 * Ciclo de Vida do Aplicativo
	 * Tempo de Parada
	 */
	public void pauseApp() {}

	/**
	 * Ciclio de Vida do Aplicativo
	 * Tempo de Finalização
	 */
	public void destroyApp(boolean unconditional) {}

	/**
	 * Manipulador de Comandos
	 */
	public void commandAction(Command c, Displayable d)
	{
		if (c == exit) this.notifyDestroyed();
	}
}
