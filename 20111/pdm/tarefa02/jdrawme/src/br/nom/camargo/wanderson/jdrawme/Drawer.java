package br.nom.camargo.wanderson.jdrawme;

import java.util.Vector;
import javax.microedition.lcdui.Canvas;
import javax.microedition.lcdui.Graphics;

/**
 * Gerenciador de Desenho
 * @author Wanderson Henrique Camargo Rosa
 */
public class Drawer extends Canvas
{
	/**
	 * Posição Atual do Cursor
	 */
	private Cursor cursor;

	/**
	 * Cor de Fundo
	 */
	private Color background;

	/**
	 * Cor de Desenho
	 */
	private Color foreground;

	/**
	 * Lista de Pontos
	 */
	private Vector list;

	/**
	 * Construtor Padrão
	 */
	public Drawer()
	{
		/* Inicialização */
		list = new Vector();
		/* Ponteiro Inicial */
		Cursor c = new Cursor(0, 0);
		c.setSize(10).setStep(5);
		this.setCursor(c);
		/* Cor de Fundo Inicial */
		this.setBackground(new Color(0,0,0));
		/* Cor de Desenho Inicial */
		this.setForeground(new Color(255,0,0));
	}

	/**
	 * Configura o Cursor
	 * @param current Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Drawer setCursor(Cursor cursor)
	{
		this.cursor = cursor;
		return this;
	}

	/**
	 * Configura a Cor de Fundo
	 * @param background Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Drawer setBackground(Color background)
	{
		this.background = background;
		return this;
	}

	/**
	 * Configura a Cor de Desenho
	 * @param foreground Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Drawer setForeground(Color foreground)
	{
		this.foreground = foreground;
		return this;
	}

	/**
	 * Informa o Cursor
	 * @return Elemento para Informação
	 */
	public Cursor getCursor()
	{
		return this.cursor;
	}

	/**
	 * Informa a Cor de Fundo
	 * @return Elemento para Informação
	 */
	public Color getBackground()
	{
		return this.background;
	}

	/**
	 * Informa a Cor de Desenho
	 * @return Elemento para Informação
	 */
	public Color getForeground()
	{
		return this.foreground;
	}

	/**
	 * Exibição Inicial de Tela
	 * Utilizada para Primeira Renderização
	 */
	protected void paint(Graphics g)
	{
		/* Cor de Fundo */
		Color background = this.getBackground();
		g.setColor(background.getColor());
		g.fillRect(0, 0, this.getWidth(), this.getHeight());
		/* Renderização de Elementos */
		Color foreground = this.getForeground();
		g.setColor(foreground.getColor());
		Cursor p;
		for (int i = 0; i < list.size(); i++) {
			p = (Cursor) list.elementAt(i);
			g.fillRect(p.getX(), p.getY(), p.getWidth(), p.getHeight());
		}
		/* Cursor */
		g.setColor(background.getInverseColor());
		Cursor c = this.getCursor();
		g.fillRect(c.getX(), c.getY(), c.getWidth(), c.getHeight());
	}

	/**
	 * Controle de Teclas Pressionadas
	 */
	protected void keyPressed(int keyCode)
	{
		Cursor c = this.getCursor();
		Cursor p; /* Elemento para Renderização */
		switch (keyCode) {
		case Drawer.KEY_NUM6: /* Direita */
		case Drawer.RIGHT:
			c.moveRight();
			break;
		case Drawer.KEY_NUM4: /* Esquerda */
		case Drawer.LEFT:
			c.moveLeft();
			break;
		case Drawer.KEY_NUM2: /* Cima */
		case Drawer.UP:
			c.moveUp();
			break;
		case Drawer.KEY_NUM8: /* Baixo */
		case Drawer.DOWN:
			c.moveDown();
			break;
		case Drawer.KEY_NUM5: /* Ação */
		case Drawer.FIRE:
			p = new Cursor(c.getX(), c.getY());
			p.setSize(c.getSize()).setStep(c.getStep());
			list.addElement(p);
			break;
		}
		this.repaint();
	}
}
