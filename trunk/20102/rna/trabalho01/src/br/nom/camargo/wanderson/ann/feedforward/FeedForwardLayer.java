package br.nom.camargo.wanderson.ann.feedforward;

import java.io.*;
import br.nom.camargo.wanderson.ann.activation.*;
import br.nom.camargo.wanderson.ann.matrix.*;

/**
 * FeedForwardLayer Class
 * Camada para rede com alimentação para frente que trabalha como uma lista
 * duplamente encadeada para comunicação interna entre os neurônios
 * @author Wanderson Henrique Camargo Rosa
 */
public class FeedForwardLayer implements Serializable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 605689554268814791L;

    /**
     * Último Resultado Gerado pela Camada
     */
    private double fire[];

    /**
     * Função de Ativação da Camada
     */
    private Activation function;

    /**
     * Pesos Configurados para a Camada
     */
    private Matrix weights;

    /**
     * Próxima Camada da Rede
     */
    private FeedForwardLayer next;

    /**
     * Camada Anterior da Rede
     */
    private FeedForwardLayer previous;

    /**
     * Construtor Padrão
     * @param neurons Número de Neurônios
     * @param function Função de Ativação para a Camada
     * @throws FeedForwardException Número Inválido de Neurônios
     */
    public FeedForwardLayer(int neurons, Activation function)
        throws FeedForwardException
    {
        if (!(neurons > 0)) {
            throw new FeedForwardException("Invalid Neurons Number");
        }
        this.fire = new double[neurons];
        this.function = function;
    }

    /**
     * Construtor Rápido
     * @param neurons Número de Neurônios
     * @throws FeedForwardException Número Inválido de Neurônios
     */
    public FeedForwardLayer(int neurons) throws FeedForwardException
    {
        this(neurons, new Sigmoid());
    }

    /**
     * Número de Neurônios da Camada
     * @return Quantidade de Neurônios
     */
    public int getNeuronCount()
    {
        return this.fire.length;
    }

    /**
     * Configuração de Saída Atual para a Camada
     * @param neuron Número do Neurônio
     * @param value Valor de Saída
     * @return Próprio Objeto para Encadeamento
     * @throws FeedForwardException Neurônio Inválido
     */
    public FeedForwardLayer setFire(int neuron, double value)
        throws FeedForwardException
    {
        if (!(neuron >= 0 && neuron < this.getNeuronCount())) {
            throw new FeedForwardException("Invalid Neuron");
        }
        this.fire[neuron] = value;
        return this;
    }

    /**
     * Informação da Saída do Neurônio para a Camada
     * @param neuron Número do Neurônio
     * @return Valor de Saída para o Neurônio
     * @throws FeedForwardException Neurônio Inválido
     */
    public double getFire(int neuron) throws FeedForwardException
    {
        if (!(neuron >= 0 && neuron < this.getNeuronCount())) {
            throw new FeedForwardException("Invalid Neuron");
        }
        return this.fire[neuron];
    }

    /**
     * Informação da Saída Completa da Camada
     * @return Valores de Saída da Camada
     */
    public double[] getFire()
    {
        return this.fire;
    }

    /**
     * Configuração da Próxima Camada
     * @param next Próxima Camada da Rede
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer setNext(FeedForwardLayer next)
    {
        this.next = next;
        next.setPrevious(this);
        int size = this.getNeuronCount() + 1; // Neurons + Bias
        try {
            this.weights = new Matrix(size, next.getNeuronCount());
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return this;
    }

    /**
     * Configuração da Camada Anterior
     * @param previous Camada Anterior da Rede
     * @return Próprio Objeto para Encadeamento
     */
    private FeedForwardLayer setPrevious(FeedForwardLayer previous)
    {
        this.previous = previous;
        return this;
    }

    /**
     * Informação de Pesos da Camada
     * @return Matriz Representante de Pesos da Camada
     */
    public Matrix getWeights()
    {
        return this.weights;
    }

    /**
     * Informação da Próxima Camada da Rede
     * @return Camada Solicitada
     */
    public FeedForwardLayer getNext()
    {
        return this.next;
    }

    /**
     * Informação da Camada Anterior da Rede
     * @return Camada Solicitada
     */
    public FeedForwardLayer getPrevious()
    {
        return this.previous;
    }

    /**
     * Verificação de Camada de Entrada
     * @return Confirmação da Solicitação
     */
    public boolean isInput()
    {
        return this.previous == null;
    }

    /**
     * Verificação de Camada de Saída
     * @return Confirmação da Solicitação
     */
    public boolean isOutput()
    {
        return this.next == null;
    }

    /**
     * Reinicialização dos Pesos da Camada
     * @param min Valor Mínimo
     * @param max Valor Máximo
     * @return Próprio Objeto para Encadeamento
     */
    public FeedForwardLayer reset(double min, double max)
    {
        if (this.getWeights() != null) {
            this.getWeights().randomize(min, max);
        }
        return this;
    }

    /**
     * Informação da Função de Ativação
     * @return Função de Ativação Configurada
     */
    public Activation getFunction()
    {
        return this.function;
    }

    /**
     * Visualização dos Pesos da Camada
     * @return Pesos da Camada Formatados ou Aviso de Camada de Saída
     */
    public String toString()
    {
        if (this.getWeights() != null) {
            return this.getWeights().toString();
        } else {
            return "[ Output Layer ]";
        }
    }

    /**
     * Computação de Padrão de Entrada
     * @param input Padrão de Entrada para a Rede Neural
     * @return Padrão de Saída da Rede
     */
    public double[] compute(double input[]) throws FeedForwardException
    {
        if (!this.isInput()) {
            throw new FeedForwardException("Invalid Input in this Layer");
        }
        if (input.length != this.getNeuronCount()) {
            throw new FeedForwardException("Invalid Input Length");
        }
        for (int i = 0; i < input.length; i++) {
            this.setFire(i, input[i]);
        }
        return this.compute();
    }

    /**
     * Recursão para Entrada de Padrões
     * @return Valor de Saída para a Rede Neural
     * @throws FeedForwardException Erro Interno de Acesso aos Neurônios
     */
    private double[] compute() throws FeedForwardException
    {
        if (this.isOutput()) {
            return this.getFire();
        }
        double fire[] = this.getFire();
        Matrix input = FeedForwardLayer.createInputMatrix(fire);
        int count = this.getNext().getNeuronCount();
        Matrix column;
        double product;
        try {
            for (int i = 0; i < count; i++) {
                column = this.getWeights().getCol(i);
                product = column.dotProduct(input);
                this.getNext().setFire(i, this.getFunction().activate(product));
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return this.getNext().compute();
    }

    /**
     * Cria uma Matriz Vetorial em Linha Representante do Padrão
     * @param pattern Padrão de Entrada
     * @return Matriz Representante
     */
    private static Matrix createInputMatrix(double pattern[])
    {
        double values[] = new double[pattern.length + 1];
        for (int i = 0; i < pattern.length; i++) {
            values[i] = pattern[i];
        }
        values[pattern.length] = 1; // Threshold
        return Matrix.createRowMatrix(values);
    }
}
