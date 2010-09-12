package br.unisinos.ann;

/**
 * Classe Neurônio
 * Abstração de Classe para Especialização de
 *  Funções de Transferência e Ativação
 * Redes Neurais Artificiais
 * @author Wanderson Henrique Camargo Rosa
 */
public abstract class Neuron
{
    /**
     * Pesos do Neurônio
     */
    protected double weights[];

    /**
     * Peso do Bias
     */
    protected double bias;

    /**
     * Construtor da Classe
     * @param signals Quantidade de Sinais de Entrada
     */
    public Neuron(int signals)
    {
        /*
         * Construção dos Pesos Iniciais Randômicos
         */
        this.weights = new double[signals];
        this.bias    = Math.random();
        for (int i = 0; i < this.weights.length; i++) {
            this.weights[i] = Math.random();
        }
    }

    /**
     * Ativação do Neurônio
     * Execução da Transferência de Impulsos entre Neurônios
     * @param signals Sinais de Entrada
     * @param bias Entrada Fixa
     * @return Valor Computado Conforme Funções de Ativação e Transferência
     * @throws AnnException Quantidade de Sinais Difere do Número de Pesos
     */
    public double activate(double signals[], double bias) throws AnnException
    {
        /*
         * Quantidade de Sinais de Entrada Difere do Construtor
         */
        if (signals.length != this.weights.length) {
            throw new AnnException("Invalid Number of Signals");
        }

        /*
         * Somatório dos Pesos Aplicados aos Sinais de Entrada
         */
        double output = 0;
        for (int i = 0; i < this.weights.length; i++) {
            output += signals[i] * this.weights[i];
        }
        output += this.bias * bias;

        /*
         * Processamento da Função de Ativação e Transferência
         */
        output = this.activation(output);
        output = this.transference(output);
        return output;
    }

    /**
     * Função de Ativação Interna ao Neurônio
     * @param input Entrada da Função
     * @return Resultado do Processamento
     */
    public abstract double activation(double input);

    /**
     * Função de Transferência Interna ao Neurônio
     * @param input Entrada da Função
     * @return Resultado do Processamento
     */
    public abstract double transference(double input);
}
