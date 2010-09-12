package br.unisinos.ann;

public abstract class ThresholdNeuron extends Neuron
{
    public ThresholdNeuron(int signals)
    {
        super(signals);
    }

    public double activation(double input)
    {
        if (input >= 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
