package br.unisinos.ann;

/**
 * Neurônio Artificial
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class Neuron
{
    /**
     * Pesos Sinápticos
     */
    public double weights[];

    /**
     * Construtor da Classe
     * @param numberOfInputs Número de Entradas para o Neurônio
     */
    public Neuron(int numberOfInputs)
    {
        this.setNumberOfInputs(numberOfInputs);
    }

    /**
     * Configura o Número de Entradas do Neurônio Reinicializando os Pesos
     * @param value Quantidade de Entradas para o Objeto
     * @return Próprio Objeto
     */
    protected Neuron setNumberOfInputs(int value)
    {
        weights = new double[value];
        for (int i = 0; i < value; i++) {
            weights[i] = Math.random() * (Math.random() >= 0.5 ? 1 : -1);
        }
        return this;
    }

    /**
     * Informa os Pesos Configurados no Neurônio
     * @return Valor dos Pesos do Neurônio
     */
    public double[] getWeights()
    {
        return weights;
    }

    /**
     * Ativação do Neurônio
     * @param function Função Escolhida
     * @param inputs Valores de Entrada
     * @return Saída Esperada
     * @throws AnnException Tamanho de Entrada Difere do Número de Pesos
     * @throws AnnException Função de Transferência Inválida
     */
    public double activate(NeuronFunction function, double inputs[])
        throws AnnException
    {
        if (inputs.length != weights.length) {
            throw new AnnException("Invalid Input Size");
        }

        double sum = 0;
        for (int i = 0; i < inputs.length; i++) {
            sum = sum + inputs[i] * weights[i];
        }

        return function.transfer(sum);
    }

    /**
     * Método Principal de Execução
     * @param args Argumentos de Entrada
     * @throws Exception Erros Variados
     */
    public static void main(String args[]) throws Exception
    {
        Neuron neuron = new Neuron(2);
        double inputs[] = new double[2];
        inputs[0] = 0.5;
        inputs[1] = 0.8;
        double result = neuron.activate(NeuronFunction.THRESHOLD, inputs);
        System.out.println(result);
    }

}
