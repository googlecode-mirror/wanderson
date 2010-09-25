package br.unisinos.ann;

public class Neuron
{
    public double weights[];

    public Neuron(int numberOfInputs)
    {
        this.setNumberOfInputs(numberOfInputs);
    }

    protected Neuron setNumberOfInputs(int value)
    {
        weights = new double[value];
        for (int i = 0; i < value; i++) {
            weights[i] = Math.random();
        }
        return this;
    }

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
