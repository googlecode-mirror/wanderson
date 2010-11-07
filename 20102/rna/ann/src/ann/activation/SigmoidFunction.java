package ann.activation;

/**
 * Função de Ativação Sigmóide
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class SigmoidFunction implements Activation
{
    public double activate(double value)
    {
        return 1.0 / (1 + Math.exp(-1.0 * value));
    }

    public double derivate(double value)
    {
        return value * (1.0 - value);
    }
}
