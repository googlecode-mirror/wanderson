package br.nom.camargo.wanderson.ann.activation;

import java.io.*;

/**
 * Interface para Funções de Ativação
 * @author Wanderson Henrique Camargo Rosa
 */
public interface Activation extends Serializable
{
    /**
     * Ativação da Função
     * @param value Valor de Entrada
     * @return Resultado de Saída
     */
    public double activate(double value);
    /**
     * Derivada da Função
     * @param value Valor de Entrada
     * @return Resultado de Saída
     */
    public double derive(double value);
}
