package ann.feedforward.backpropagation;

import ann.util.*;
import ann.matrix.*;
import ann.activation.*;
import ann.feedforward.*;

/**
 * Camada Utilizada pelo Algoritmo de Aprendizado Back Propagation
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class BackPropagationLayer
{
    /**
     * Taxa de Erro para Cada Neurônio da Camada
     */
    private double error[];

    /**
     * Taxa de Erro Delta
     */
    private double delta[];

    /**
     * Matriz de Acúmulo de Erros Delta
     */
    private Matrix accumulateErrorDelta;

    /**
     * Matriz de Erros Delta
     */
    private Matrix matrixDelta;

    /**
     * Objeto Pai para Visualização
     */
    private BackPropagation backpropagation;

    /**
     * Camada da Rede em Treinamento Conforme Mapeamento
     */
    private FeedForwardLayer layer;

    /**
     * Posição do Bias
     */
    private int biasIndex;

    /**
     * Construtor Padrão
     * @param backpropagation Objeto Pai para Visualização
     * @param layer Camada da Rede de Treinamento Conforme Mapeamento
     */
    public BackPropagationLayer(BackPropagation backpropagation,
        FeedForwardLayer layer)
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
            this.biasIndex = count;
        }
    }

    /**
     * Cálculo do Erro da Camada
     * Executado Somente para a Camada de Saída da Rede Neural
     * @param ideal Valores Ideais de Saída
     * @return Próprio Objeto para Encadeamento
     */
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

    /**
     * Cálculo do Erro da Camada
     * Executado Somente para as Camadas Intermediárias e de Entradas
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer calcError()
    {
        FeedForwardLayer layer = this.getLayer();
        BackPropagationLayer next =
            this.getBackPropagation().getBackPropagationLayer(layer.getNext());

        for (int i = 0; i < layer.getNext().getNeuronCount(); i++) {
            for (int j = 0; j < layer.getNeuronCount(); j++) {
                this.accumulateMatrixDelta(j, i, next.getErrorDelta(i) * layer.getFire(j));
                this.setError(j, this.getError(j) + layer.getWeights().get(j, i) * next.getErrorDelta(i));
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

    /**
     * Acúmulo de Delta para a Camada
     * @param row Neurônio Origem
     * @param col Neurônio Destino
     * @param value Delta da Conexão
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer accumulateMatrixDelta(int row, int col, double value)
    {
        this.accumulateErrorDelta.add(row, col, value);
        return this;
    }

    /**
     * Acúmulo de Delta para o Bias
     * @param index Neurônio Destino
     * @param value Delta da Conexão
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer accumulateThresholdDelta(int index, double value)
    {
        this.accumulateErrorDelta.add(this.biasIndex, index, value);
        return this;
    }

    /**
     * Cálculo do Delta para o Neurônio
     * @param neuron Posição do Neurônio na Camada
     * @return Valor do Cálculo
     */
    public double calcDelta(int neuron)
    {
        double output = this.getLayer().getFire(neuron);
        Activation function = this.getLayer().getFunction();
        return this.getError(neuron) * function.derivate(output);
    }

    /**
     * Configuração do Erro para o Neurônio
     * @param neuron Posição do Neurônio na Camada
     * @param value Valor do Erro do Neurônio
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer setError(int neuron, double value)
    {
        this.error[neuron] = value;
        return this;
    }

    /**
     * Informação do Erro do Neurônio
     * @param neuron Posição do Neurônio na Camada
     * @return Valor do Erro do Neurônio
     */
    public double getError(int neuron)
    {
        return this.error[neuron];
    }

    /**
     * Limpeza dos Valores de Erro para a Camada
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer clearError()
    {
        int count = this.getLayer().getNeuronCount();
        for (int i = 0; i < count; i++) {
            this.error[i] = 0;
        }
        return this;
    }

    /**
     * Configura o Erro Delta para o Neurônio
     * @param neuron Posição do Neurônio na Camada
     * @param value Valor do Erro do Neurônio
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer setErrorDelta(int neuron, double value)
    {
        this.delta[neuron] = value;
        return this;
    }

    /**
     * Informa o Erro Delta para o Neurônio
     * @param neuron Posição do Neurônio na Camada
     * @return Erro do Neurônio
     */
    public double getErrorDelta(int neuron)
    {
        return this.delta[neuron];
    }

    /**
     * Limpeza dos Valores de Erro Delta da Camada
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer clearErrorDelta()
    {
        int count = this.getLayer().getNeuronCount();
        for (int i = 0; i < count; i++) {
            this.error[i] = 0;
        }
        return this;
    }

    /**
     * Informa a Camada Configurada Conforme Mapeamento
     * @return Camada da Rede Feed Forward
     */
    public FeedForwardLayer getLayer()
    {
        return this.layer;
    }

    /**
     * Informa o Objeto Pai para Visualização
     * @return Objeto Pai Configurado
     */
    public BackPropagation getBackPropagation()
    {
        return this.backpropagation;
    }

    /**
     * Aprendizado da Camada
     * @param rate Fator de Aprendizado
     * @param momentum Fator de Momento
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagationLayer learn(double rate, double momentum)
    {
        if (this.getLayer().hasWeights()) {
            Matrix m1 = this.accumulateErrorDelta.multiply(rate);
            Matrix m2 = this.matrixDelta.multiply(momentum);
            this.matrixDelta = m1.add(m2);
            this.getLayer().setWeights(
                this.getLayer().getWeights().add(this.matrixDelta)
            );
            this.accumulateErrorDelta.clear();
        }
        return this;
    }
}
