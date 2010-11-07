package ann.activation;

/**
 * Função de Ativação Tangente Hiperbólica
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class HyperbolicTangentFunction implements Activation
{
    public double activate(double value)
    {
        return (Math.exp(value * 2.0) - 1.0) / (Math.exp(value * 2.0) + 1.0);
    }

    public double derivate(double value)
    {
        return 1.0 - Math.pow(this.activate(value), 2.0);
    }
}
