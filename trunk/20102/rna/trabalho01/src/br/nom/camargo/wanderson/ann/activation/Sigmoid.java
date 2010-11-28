package br.nom.camargo.wanderson.ann.activation;

/**
 * Função Sigmóide
 * @author Wanderson Henrique Camargo Rosa
 */
public class Sigmoid implements Activation
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -5084700722463881241L;

    /**
     * Ativação da Função Sigmóide
     * @param value Valor de Entrada
     * @return Resultado de Saída
     */
    public double activate(double value)
    {
        return 1.0 / (1 + Math.exp(-1 * value));
    }

    /**
     * Derivada da Função Sigmóide
     * @param value Valor de Entrada
     * @return Resultado de Saída
     */
    public double derivate(double value)
    {
        return value * (1 - value);
    }
}
