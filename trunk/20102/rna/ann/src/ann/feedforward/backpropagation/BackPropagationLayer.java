package ann.feedforward.backpropagation;

import ann.util.*;
import ann.matrix.*;
import ann.activation.*;
import ann.feedforward.*;

public class BackPropagationLayer
{
    private double error[];
    private double delta[];

    private Matrix accumulateErrorDelta;
    private Matrix matrixDelta;
    private BackPropagation backpropagation;
    private FeedForwardLayer layer;

    int biasIndex;

    public BackPropagationLayer(BackPropagation backpropagation, FeedForwardLayer layer)
    {
        this.backpropagation = backpropagation;
        this.layer = layer;

        int count = layer.getNeuronCount();
        this.error = new double[count];
        this.delta = new double[count];

        if (layer.getNext() != null) {
            int counterNext = layer.getNext().getNeuronCount();
            this.accumulateErrorDelta = new Matrix(count + 1, counterNext);
            this.matrixDelta = new Matrix(count + 1, counterNext);
            this.biasIndex = layer.getNeuronCount();
        }
    }

    public BackPropagationLayer calcError(double ideal[])
    {
        FeedForwardLayer layer = this.getLayer();
        int count = layer.getNeuronCount();
        for (int i = 0; i < count; i++) {
            this
                .setError(i, ideal[i] - layer.getFire(i))
                .setErrorDelta(i, Bounder.bound(this.calcDelta(i)));
        }
        return this;
    }

    public BackPropagationLayer calcError()
    {
        FeedForwardLayer layer = this.getLayer();
        BackPropagationLayer next =
            this.getBackPropagation().getBackPropagationLayer(layer);

        for (int i = 0; i < layer.getNext().getNeuronCount(); i++) {
            for (int j = 0; j < layer.getNeuronCount(); j++) {
                this.accumulateMatrixDelta(j, i, next.getErrorDelta(i) * layer.getFire(i));
                this.setError(j, this.getError(j) + layer.getWeight().get(j, i) * next.getErrorDelta(i));
            }
            this.accumulateThresholdDelta(i, next.getErrorDelta(i));
        }

        if (layer.isHidden()) {
            for (int i = 0; i < layer.getNeuronCount(); i++) {
                this.setErrorDelta(i, Bounder.bound(this.calcDelta(i)));
            }
        }

        return this;
    }

    public BackPropagationLayer accumulateMatrixDelta(int row, int col, double value)
    {
        this.accumulateErrorDelta.add(row, col, value);
        return this;
    }

    public BackPropagationLayer accumulateThresholdDelta(int index, double value)
    {
        this.accumulateErrorDelta.add(this.biasIndex, index, value);
        return this;
    }

    public double calcDelta(int neuron)
    {
        Activation function = this.getLayer().getFunction();
        return this.getError(neuron) * function.derivate(neuron);
    }

    public BackPropagationLayer setError(int neuron, double value)
    {
        this.error[neuron] = value;
        return this;
    }

    public double getError(int neuron)
    {
        return this.error[neuron];
    }

    public BackPropagationLayer clearError()
    {
        int count = this.getLayer().getNeuronCount();
        for (int i = 0; i < count; i++) {
            this.error[i] = 0;
        }
        return this;
    }

    public BackPropagationLayer setErrorDelta(int neuron, double value)
    {
        this.delta[neuron] = value;
        return this;
    }

    public double getErrorDelta(int neuron)
    {
        return this.delta[neuron];
    }

    public BackPropagationLayer clearErrorDelta()
    {
        int count = this.getLayer().getNeuronCount();
        for (int i = 0; i < count; i++) {
            this.error[i] = 0;
        }
        return this;
    }

    public FeedForwardLayer getLayer()
    {
        return this.layer;
    }

    public BackPropagation getBackPropagation()
    {
        return this.backpropagation;
    }
}
