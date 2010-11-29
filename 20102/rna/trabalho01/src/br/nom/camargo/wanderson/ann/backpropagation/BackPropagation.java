package br.nom.camargo.wanderson.ann.backpropagation;

import java.util.*;
import br.nom.camargo.wanderson.ann.feedforward.*;

/**
 * BackPropagation Class
 * Treinamento para Redes com Alimentação para Frente
 * @author Wanderson Henrique Camargo Rosa
 */
public class BackPropagation
{
    /**
     * Erro Atual da Rede
     */
    private double error;

    /**
     * Valores de Entrada
     */
    private double input[][];

    /**
     * Valores Ideais de Saída
     */
    private double ideal[][];

    /**
     * Taxa de Aprendizado
     */
    private double learn;

    /**
     * Taxa Momentânea
     */
    private double momentum;

    /**
     * Mapeador de Camadas da Rede e BackPropagation
     */
    private HashMap<FeedForwardLayer, BackPropagationLayer> mapper;

    /**
     * Rede para Receber Treinamento
     */
    private FeedForwardNetwork network;

    /**
     * Construtor Padrão
     * @param network Rede Neural
     * @param input Dados de Entrada
     * @param ideal Valores Ideais de Saída
     * @param learn Taxa de Aprendizado
     * @param momentum Taxa Momentânea
     */
    public BackPropagation(FeedForwardNetwork network, double input[][],
        double ideal[][], double learn, double momentum)
    {
        this.network  = network;
        this.learn    = learn;
        this.momentum = momentum;
        this.input    = input;
        this.ideal    = ideal;

        this.mapper = new HashMap<FeedForwardLayer, BackPropagationLayer>();
        for (FeedForwardLayer layer : network.getLayers()) {
            this.mapper.put(layer, new BackPropagationLayer(this, layer));
        }
    }

    /**
     * Cálculo de Erro para a Rede
     * @param ideal Valores Ideais de Saída
     * @return Próprio Objeto para Encadeamento
     */
    private BackPropagation calculate(double ideal[])
    {
        for (FeedForwardLayer layer : network.getLayers()) {
            mapper.get(layer).clearError();
        }
        try {
            mapper.get(network.getOutputLayer()).calculate(ideal);
        } catch (BackPropagationException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return this;
    }

    /**
     * Aprendizado da Rede
     * @return Próprio Objeto para Encadeamento
     */
    private BackPropagation learn()
    {
        for (FeedForwardLayer layer : network.getLayers()) {
            mapper.get(layer).learn(learn, momentum);
        }
        return this;
    }

    /**
     * Iteração Completa
     * 1) Computação de Todas as Entradas
     * 2) Cálculo de Erro Completo na Rede
     * 3) Aprendizado
     * 4) Configuração do Erro Atual
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagation iterate()
    {
        try {
            for (int i = 0; i < input.length; i++) {
                network.compute(input[i]); // Configure Fire and Save State
                calculate(ideal[i]); // Calculate Error Over Saved State
            }
            learn();
            this.setError(network.error(input, ideal));
        } catch (FeedForwardException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return this;
    }

    /**
     * Configuração do Erro Atual do Algoritmo de Aprendizado
     * @param error Valor de Erro
     * @return Próprio Objeto para Encadeamento
     */
    private BackPropagation setError(double error)
    {
        this.error = error;
        return this;
    }

    /**
     * Informação do Erro Atual do Algoritmo de Aprendizado
     * @return Valor do Erro
     */
    public double getError()
    {
        return this.error;
    }

    /**
     * Mapeamento de Camadas de BackPropagation
     * @param layer Camada da Rede Neural com Alimentação para Frente
     * @return Camada Encontrada
     * @throws BackPropagationException Camada Inválida
     */
    public BackPropagationLayer getBackPropagationLayer(FeedForwardLayer layer)
        throws BackPropagationException
    {
        BackPropagationLayer bp = mapper.get(layer);
        if (bp == null) {
            throw new BackPropagationException("Invalid Layer");
        }
        return bp;
    }
}
