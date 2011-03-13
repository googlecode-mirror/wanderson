package br.nom.camargo.wanderson.jdrawme;

/**
 * Emulador de Cursor
 * @author Wanderson Henrique Camargo Rosa
 */
public class Cursor extends Point
{
	/**
	 * Tamanho do Cursor
	 */
	private int size;

	/**
	 * Quantidade de Passos
	 */
	private int step;

	/**
	 * Construtor Padrão
	 * @param x Posição Inicial na Abscissa
	 * @param y Posição Inicial na Ordenada
	 */
	public Cursor(int x, int y)
	{
		super(x,y);
		this.setSize(1).setStep(1);
	}

	/**
	 * Configura o Tamanho do Cursor
	 * @param size Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Cursor setSize(int size)
	{
		if (size < 1) size = 1;
		this.size = size;
		return this;
	}

	/**
	 * Configura a Quantidade de Passos
	 * @param step Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	public Cursor setStep(int step)
	{
		this.step = step;
		return this;
	}

	/**
	 * Informa o Tamanho do Cursor
	 * @return Elemento para Informação
	 */
	public int getSize()
	{
		return this.size;
	}

	/**
	 * Informa a Quantidade de Passos
	 * @return Elemento para Informação
	 */
	public int getStep()
	{
		return this.step;
	}

	/**
	 * Informa o Tamanho Horizontal
	 * @return Elemento para Informação
	 */
	public int getWidth()
	{
		return this.getSize();
	}

	/**
	 * Informa o Tamanho Vertical
	 * @return Elemento para Informação
	 */
	public int getHeight()
	{
		return this.getSize();
	}

	/**
	 * Movimenta o Cursor na Horizontal
	 * @param modifier Elemento Modificador
	 * @return Próprio Objeto para Encadeamento
	 */
	protected Cursor horizontal(int modifier)
	{
		int x = this.getX();
		int s = this.getStep();
		this.setX(x + s * modifier);
		return this;
	}

	/**
	 * Movimenta o Cursor na Vertical
	 * @param modifier Elemento Modificador
	 * @return Próprio Objeto para Encadeamento
	 */
	protected Cursor vertical(int modifier)
	{
		int y = this.getY();
		int s = this.getStep();
		this.setY(y + s * modifier);
		return this;
	}

	/**
	 * Movimenta o Cursor para a Direita
	 * @return Próprio Objeto para Encadeamento
	 */
	public Cursor moveRight()
	{
		this.horizontal(1);
		return this;
	}

	/**
	 * Movimenta o Cursor para a Esquerda
	 * @return Próprio Objeto para Encadeamento
	 */
	public Cursor moveLeft()
	{
		this.horizontal(-1);
		return this;
	}

	/**
	 * Movimenta o Cursor para Baixo
	 * @return Próprio Objeto para Encadeamento
	 */
	public Cursor moveDown()
	{
		this.vertical(1);
		return this;
	}

	/**
	 * Movimenta o Cursor para Cima
	 * @return Próprio Objeto para Encadeamento
	 */
	public Cursor moveUp()
	{
		this.vertical(-1);
		return this;
	}
}
