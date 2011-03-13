package br.nom.camargo.wanderson.jdrawme;

/**
 * Ponto para Renderização
 * @author Wanderson Henrique Camargo Rosa
 */
public class Point
{
	/**
	 * Posição Abscissa
	 */
	private int x;

	/**
	 * Posição Ordenada
	 */
	private int y;

	/**
	 * Construtor da Classe
	 * @param x Posição Abscissa
	 * @param y Posição Ordenada
	 */
	public Point(int x, int y)
	{
		this.setX(x).setY(y);
	}

	/**
	 * Configura a Posição Abscissa
	 * @param x Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Point setX(int x)
	{
		this.x = x;
		return this;
	}

	/**
	 * Configura a Posição Ordenada
	 * @param y Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Point setY(int y)
	{
		this.y = y;
		return this;
	}

	/**
	 * Informa a Posição Abscissa
	 * @return Elemento para Informação
	 */
	public int getX()
	{
		return this.x;
	}

	/**
	 * Informa a Posição Ordenada
	 * @return Elemento para Informação
	 */
	public int getY()
	{
		return this.y;
	}
}
