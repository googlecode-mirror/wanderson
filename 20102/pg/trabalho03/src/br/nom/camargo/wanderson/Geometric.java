package br.nom.camargo.wanderson;

/**
 * Elementos Geométricos Disponíveis
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public enum Geometric
{
    POINT("Point"), LINE("Line"), POLYGON("Polygon"), RECTANGLE("Rectangle"),
        SQUARE("Square"), ELLIPSE("Ellipse"), CIRCLE("Circle"), FILL("Fill");

    /**
     * Nome do Elemento
     */
    protected String name;

    /**
     * Construtor Padrão
     * @param name Nome do Elemento
     */
    private Geometric(String name)
    {
        this.name = name;
    }

    /**
     * Exibição do Nome do Elemento
     */
    public String toString()
    {
        return this.name;
    }
}
