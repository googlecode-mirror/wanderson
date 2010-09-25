package br.unisinos.ann;

import java.lang.reflect.Method;

/**
 * Funções de Transferência
 * 
 * Encapsulamento das funções que são acessadas por padrão reflexível disponível
 * na linguagem.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public enum NeuronFunction
{
    THRESHOLD ("threshold"), SIGMOID ("sigmoid"), HYPERBOLIC ("hyperbolic");

    /**
     * Nome da Função
     */
    private final String name;

    /**
     * Construtor do Elemento Enumerável
     * @param name Nome da Função Desejada
     */
    private NeuronFunction(String name)
    {
        this.name = name;
    }

    /**
     * Acesso Encapsulado para a Função de Transferência
     * @param input Valor de Entrada
     * @return Saída Esperada para a Função Escolhida
     * @throws AnnException Função Inválida
     */
    public double transfer(double input) throws AnnException
    {
        double result;
        try {
            @SuppressWarnings("rawtypes")
            Class[] params = new Class[1];
            params[0] = Double.class;
            Method method = this.getClass().getMethod(name, params);
            Object args[] = new Object[1];
            args[0] = input;
            result = (Double) method.invoke(this, args);
        } catch (Exception e) {
            throw new AnnException("Invalid Transfer Function");
        }
        return result;
    }

    /**
     * Função Rampa
     * @param input Valor de Entrada
     * @return Saída Esperada
     */
    @SuppressWarnings("unused")
    private double threshold(Double input)
    {
        return input >= 0 ? 1 : 0;
    }

    /**
     * Função Sigmóide
     * @param input Valor de Entrada
     * @return Saída Esperada
     */
    @SuppressWarnings("unused")
    private double sigmoid(Double input)
    {
        return 1/(1 + Math.pow(Math.E,(-1 * input)));
    }

    /**
     * Função Hiperbólica
     * @param input Valor de Entrada
     * @return Saída Esperada
     */
    @SuppressWarnings("unused")
    private double hyperbolic(Double input)
    {
        return Math.tanh(input);
    }
}
