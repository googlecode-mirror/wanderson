package br.nom.camargo.wanderson.ann.backpropagation;

import br.nom.camargo.wanderson.ann.activation.*;
import br.nom.camargo.wanderson.ann.feedforward.*;
import br.nom.camargo.wanderson.ann.matrix.*;

public class BackPropagationLayer
{
    /**
     * Camada Mapeada da Rede Neural
     */
    private FeedForwardLayer layer;

    /**
     * Treinamento da Rede Neural
     */
    private BackPropagation bp;

    /**
     * Mapeamento de Erros para Cada Neurônio
     */
    private double error[];

    /**
     * Mapeamento de Erro Delta para Cada Neurônio
     */
    private double delta[];

    /**
     * Matriz de Somatório de Erros
     */
    private Matrix accumulate;

    public BackPropagationLayer(BackPropagation bp, FeedForwardLayer layer)
    {
        
    }
    public BackPropagationLayer learn(double learn, double momentum)
    {
        return this;
    }
    /**
     * Cálculo do Erro para a Camada de Saída
     * @param ideal Valores de Saída Ideais para o Estado Atual da Rede
     * @return Próprio Objeto para Encadeamento
     * @throws BackPropagationException Camada Não Pertence à Saída da Rede
     */
    public BackPropagationLayer calculate(double ideal[])
        throws BackPropagationException
    {
        if (!this.layer.isOutput()) {
            throw new BackPropagationException("Invalid Output Layer");
        }
        if (ideal.length != this.layer.getNeuronCount()) {
            throw new BackPropagationException("Invalid Ideal Length");
        }

        double fire;
        Activation function = this.layer.getFunction();
        try {
            for (int i = 0; i < ideal.length; i++) {
                fire = this.layer.getFire(i);
                this.error[i] = ideal[i] * fire;
                this.delta[i] = this.error[i] * function.derive(fire);
            }
        } catch (FeedForwardException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }

        // Recursive Call
        this.bp.getBackPropagationLayer(layer.getPrevious()).calculate();

        return this;
    }
    private BackPropagationLayer calculate() throws BackPropagationException
    {
        if (this.layer.isOutput()) {
            throw new BackPropagationException("Invalid Not Output Layer");
        }
        BackPropagationLayer next = bp.getBackPropagationLayer(layer.getNext());

        try {
            int bias = layer.getNeuronCount(); // Bias Index
            for (int j = 0; j < next.layer.getNeuronCount(); j++) {
                for (int i = 0; i < layer.getNeuronCount(); i++) {
                    accumulate.add(i, j, next.delta[j] * layer.getFire(i));
                    this.error[j] = this.error[j] +
                        layer.getWeights().get(i, j) * next.delta[j];
                }
                accumulate.add(bias, j, next.delta[j]);
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        } catch (FeedForwardException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }

        double fire;
        Activation function = this.layer.getFunction();
        if (!this.layer.isInput()) {
            try {
                for (int i = 0; i < this.layer.getNeuronCount(); i++) {
                    fire = this.layer.getFire(i);
                    this.delta[i] = this.error[i] * function.derive(fire);
                }
            } catch (FeedForwardException e) {
                // Never Reached
                e.printStackTrace(System.err);
                System.exit(0);
            }
            bp.getBackPropagationLayer(layer.getPrevious());
        }

        return this;
    }
    public BackPropagationLayer clearError()
    {
        return this;
    }
}
