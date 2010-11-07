package ann.feedforward;

import ann.util.*;
import java.util.*;

/**
 * Rede FeedForward
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class FeedForwardNetwork
{
    /**
     * Conjunto de Camadas
     */
    protected ArrayDeque<FeedForwardLayer> layers;

    /**
     * Construtor Padrão
     */
    public FeedForwardNetwork()
    {
        this.layers = new ArrayDeque<FeedForwardLayer>();
    }

    /**
     * Inclui uma Camada na Rede Neural
     * @param layer Camada para Inclusão
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardNetwork addLayer(FeedForwardLayer layer)
    {
        if (!this.layers.isEmpty()) {
            FeedForwardLayer last = this.layers.getLast();
            if (last != null) {
                last.setNext(layer);
                layer.setPrevious(last);
            }
        }
        this.layers.addLast(layer);
        return this;
    }

    /**
     * Cálculo de Erro da Rede
     * @param input Padrão de Entrada
     * @param ideal Valores Ideais
     * @return Valor do Erro Atual da Rede
     */
    public double calculateError(double input[][], double ideal[][])
    {
        ErrorCalculator error = ErrorCalculator.getInstance();
        error.reset();

        for (int i = 0; i < ideal.length; i++) {
            this.computeOutputs(input[i]);
            error.update(this.getOutputLayer().getFire(), ideal[i]);
        }

        return error.rms();
    }

    /**
     * Cálculo de Entrada da Rede
     * @param input Padrão de Entrada
     * @return Valores de Saída
     */
    public double[] computeOutputs(double input[])
    {
        if (input.length != this.getInputLayer().getNeuronCount()) {
            throw new FeedForwardException("Invalid Input Size");
        }
        for (FeedForwardLayer layer : this.layers) {
            if (layer.isInput()) {
                layer.computeOutputs(input);
            } else if (!layer.isOutput()) {
                layer.computeOutputs();
            }
        }
        return this.getOutputLayer().getFire();
    }

    /**
     * Informa a Camada de Entrada da Rede
     * @return Camada de Entrada
     */
    public FeedForwardLayer getInputLayer()
    {
        return this.layers.getFirst();
    }

    /**
     * Informa a Camada de Saída da Rede
     * @return Camada de Saída
     */
    public FeedForwardLayer getOutputLayer()
    {
        return this.layers.getLast();
    }

    /**
     * Informa o Deque de Camadas da Rede
     * @return Todas as Camadas da Rede Neural Artificial
     */
    public ArrayDeque<FeedForwardLayer> getLayers()
    {
        return this.layers;
    }

    /**
     * Reinicialização das Camadas
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardNetwork reset()
    {
        for (FeedForwardLayer layer : this.layers) {
            layer.reset();
        }
        return this;
    }
}