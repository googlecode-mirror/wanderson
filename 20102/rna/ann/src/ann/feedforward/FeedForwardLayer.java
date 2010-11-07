package ann.feedforward;

import ann.activation.*;
import ann.matrix.*;

/**
 * Camada de Rede Feedforward
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class FeedForwardLayer
{
    /**
     * Último Resultado Gerado pela Camada
     */
    private double fire[];

    /**
     * Função de Ativação
     */
    private Activation function;

    /**
     * Pesos e Transferência
     */
    private Matrix weights;

    /**
     * Próxima Camada na Rede Neural
     */
    private FeedForwardLayer next;

    /**
     * Camada Anterior na Rede Neural
     */
    private FeedForwardLayer previous;

    /**
     * Construtor Padrão
     * @param function Função de Ativação
     * @param neurons  Número de Neurônios Utilizados
     */
    public FeedForwardLayer(Activation function, int neurons)
    {
        this.fire = new double[neurons];
        this.function = function;
    }

    /**
     * Construtor para Camadas com Ativação Sigmóide
     * @param neurons Número de Neurônios Utilizados
     */
    public FeedForwardLayer(int neurons)
    {
        this(new SigmoidFunction(), neurons);
    }

    /**
     * Computação de Saída para Camada Conforme Padrão Inserido
     * Utilizado em Camadas de Entrada para Inicializar os Valores
     * @param pattern Padrão de Entrada
     * @return Saída da Camada
     */
    public double[] computeOutputs(double pattern[])
    {
        int count = this.getNeuronCount();
        for (int i = 0; i < count; i++) {
            this.setFire(i, pattern[i]);
        }
        return this.computeOutputs();
    }

    /**
     * Computação de Saída para Camada Atual
     * @return Saída da Camada
     */
    public double[] computeOutputs()
    {
        double fire[] = this.getFire();
        Matrix input = FeedForwardLayer.createInputMatrix(fire);

        Matrix column;
        double product;

        int count = this.next.getNeuronCount();
        for (int i = 0; i < count; i++) {
            column = this.weights.getCol(i);
            product = column.dotProduct(input);
            this.getNext().setFire(i, this.function.activate(product));
        }

        return this.getFire();
    }

    /**
     * Cria um Vetor a Partir de Padrão Informado
     * @param pattern Padrão de Entrada
     * @return Matriz Construída com Padrão de Entrada e Limite
     */
    private static Matrix createInputMatrix(double pattern[])
    {
        double values[] = new double[pattern.length+1];
        for (int i = 0; i < pattern.length; i++) {
            values[i] = pattern[i];
        }
        values[pattern.length] = 1;

        return Matrix.createRowMatrix(values);
    }

    /**
     * Configura a Saída do Neurônio da Camada
     * @param index Número do Neurônio
     * @param value Valor de Saída do Neurônio
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer setFire(int index, double value)
    {
        this.fire[index] = value;
        return this;
    }

    /**
     * Número de Neurônios da Camada
     * @return Total de Neurônios
     */
    public int getNeuronCount()
    {
        return this.fire.length;
    }

    /**
     * Informa a Saída Completa da Camada
     * @return Valores de Todos os Neurônios da Camada
     */
    public double[] getFire()
    {
        return this.fire;
    }

    /**
     * Informa a Saída de Neurônio da Camada
     * @param index Número do Neurônio
     * @return Valor de Saída do Neurônio
     */
    public double getFire(int index)
    {
        return this.fire[index];
    }

    /**
     * Configura a Próxima Camada
     * @param next Próxima Camada
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer setNext(FeedForwardLayer next)
    {
        this.next = next;
        this.weights =
            new Matrix(this.getNeuronCount() + 1, next.getNeuronCount());
        return this;
    }

    /**
     * Configura a Camada Anterior
     * @param previous Camada Anterior
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer setPrevious(FeedForwardLayer previous)
    {
        this.previous = previous;
        return this;
    }

    /**
     * Informa a Matriz de Pesos da Camada
     * @return Matriz de Pesos
     */
    public Matrix getWeight()
    {
        return this.weights;
    }

    /**
     * Informa a Próxima Camada na Rede Neural
     * @return Próxima Camada
     */
    public FeedForwardLayer getNext()
    {
        return this.next;
    }

    /**
     * Informa a Camada Anterior na Rede Neural
     * @return Camada Anterior
     */
    public FeedForwardLayer getPrevious()
    {
        return this.previous;
    }

    /**
     * Informa se Existe uma Matriz de Pesos na Camada
     * @return Confirmação de Existência de Pesos
     */
    public boolean hasWeights()
    {
        return this.weights != null;
    }

    /**
     * Informa se a Camada Trabalha como Escondida
     * @return Confirmação de Camada Escondida
     */
    public boolean isHidden()
    {
        return this.next != null && this.previous != null;
    }

    /**
     * Informa se a Camada Trabalha como Entrada
     * @return Confirmação de Camada de Entrada
     */
    public boolean isInput()
    {
        return this.previous == null;
    }

    /**
     * Informa se a Camada Trabalha como Saída
     * @return Confirmação de Camada de Saída
     */
    public boolean isOutput()
    {
        return this.next == null;
    }

    /**
     * Reinicializa os Pesos da Matriz
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer reset()
    {
        if (this.getWeight() != null) {
            this.getWeight().randomize(-1, 1);
        }
        return this;
    }

    /**
     * Configura a Matriz de Pesos da Camada
     * @param weights Matriz de Pesos
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer setWeights(Matrix weights)
    {
        if (weights.getRows() < 2) {
            throw new FeedForwardException("Invalid Weights and Threshold");
        }
        this.fire = new double[weights.getRows() - 1];
        this.weights = weights;
        return this;
    }

    /**
     * Informa a Função de Ativação
     * @return Função de Ativação da Camada
     */
    public Activation getFunction()
    {
        return this.function;
    }
}