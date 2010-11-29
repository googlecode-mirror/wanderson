package br.nom.camargo.wanderson.ann.feedforward;

import java.io.*;
import java.util.*;
import br.nom.camargo.wanderson.ann.util.*;

/**
 * Rede Neural de Alimentação para Frente
 * @author Wanderson Henrique Camargo Rosa
 */
public class FeedForwardNetwork implements Serializable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -6300012453258207059L;

    /**
     * Camada de Entrada
     */
    private ArrayDeque<FeedForwardLayer> layers;

    /**
     * Construtor Padrão
     * @param input Camada de Entrada
     */
    public FeedForwardNetwork()
    {
        this.layers = new ArrayDeque<FeedForwardLayer>();
    }

    /**
     * Construtor Rápido
     * @param neurons Número de Neurônios entre as Camadas
     * @throws FeedForwardException Invalid Neuron Counter
     */
    public FeedForwardNetwork(int neurons[]) throws FeedForwardException
    {
        this();
        for (int current : neurons) {
            this.addLayer(new FeedForwardLayer(current));
        }
    }

    /**
     * Adiciona uma Camada na Rede
     * @param layer Camada para Adição
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardNetwork addLayer(FeedForwardLayer layer)
    {
        if (!this.layers.isEmpty()) {
            FeedForwardLayer last = this.layers.getLast();
            last.setNext(layer);
        }
        this.layers.addLast(layer);
        return this;
    }

    /**
     * Informa a Camada de Entrada
     * @return Camada Solicitada
     */
    public FeedForwardLayer getInputLayer()
    {
        return this.layers.getFirst();
    }

    /**
     * Informa a Camada de Saída
     * @return Camada Solicitada
     */
    public FeedForwardLayer getOutputLayer()
    {
        return this.layers.getLast();
    }

    /**
     * Informa as Camadas de Saída
     * @return Todas as Camadas da Rede
     */
    public FeedForwardLayer[] getLayers()
    {
        return (FeedForwardLayer[]) this.layers.toArray();
    }

    /**
     * Computação de Padrão de Entrada
     * @param input Padrões de Entrada Apresentados
     * @return Resultado Esperado pela Rede
     */
    public double[] compute(double input[]) throws FeedForwardException
    {
        if (this.getInputLayer() == null) {
            throw new FeedForwardException("Invalid Input Layer");
        }
        return this.getInputLayer().compute(input);
    }

    /**
     * Reinicialização dos Pesos da Camada
     * @param min Valor Mínimo
     * @param max Valor Máximo
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardNetwork reset(double min, double max)
    {
        for (FeedForwardLayer layer : this.layers) {
            layer.reset(min, max);
        }
        return this;
    }

    /**
     * Cálculo de Root Main Square
     * @param input Valores de Entrada
     * @param ideal Valores Esperados de Saída
     * @return Valor do Erro Atual da Rede
     * @throws FeedForwardException Tamanho
     */
    public double error(double input[][], double ideal[][])
        throws FeedForwardException
    {
        ErrorCalculator calc = ErrorCalculator.getInstance();
        calc.reset();
        double output[];
        for (int i = 0; i < input.length; i++) {
            output = this.compute(input[i]); // Configures Fire State
            calc.update(output, ideal[i]);
        }
        return calc.rms();
    }
}
