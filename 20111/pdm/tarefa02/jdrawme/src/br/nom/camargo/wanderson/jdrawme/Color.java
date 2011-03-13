package br.nom.camargo.wanderson.jdrawme;

/**
 * Controladora de Cores
 * @author Wanderson Henrique Camargo Rosa
 */
public class Color
{
	/**
	 * Intensidade de Vermelho
	 */
	private int red;

	/**
	 * Intensidade de Verde
	 */
	private int green;

	/**
	 * Intensidade de Azul
	 */
	private int blue;

	/**
	 * Construtor Padrão
	 * @param red Intensidade de Vermelho
	 * @param green Intensidade de Verde
	 * @param blue Intensidade de Azul
	 */
	public Color(int red, int green, int blue)
	{
		this.setRed(red).setGreen(green).setBlue(blue);
	}

	/**
	 * Filtro de Cores
	 * @param color Cor para Filtragem
	 * @return Cor Filtrada
	 */
	protected static int filter(int color)
	{
		if (color > 255) color = 255;
		else if (color < 0) color = 0;
		return color;
	}

	public Color setRed(int red)
	{
		this.red = Color.filter(red);
		return this;
	}

	public Color setGreen(int green)
	{
		this.green = Color.filter(green);
		return this;
	}

	public Color setBlue(int blue)
	{
		this.blue = Color.filter(blue);
		return this;
	}

	public int getRed()
	{
		return this.red;
	}

	public int getGreen()
	{
		return this.green;
	}

	public int getBlue()
	{
		return this.blue;
	}

	public int getColor()
	{
		int red   = this.getRed();
		int green = this.getGreen();
		int blue  = this.getBlue();
		return red << 16 | green << 8 | blue;
	}

	public int getInverseColor()
	{
		int color = this.getColor();
		return ~color;
	}
}
