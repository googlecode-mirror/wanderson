package ann.activation;

import java.io.*;

/**
 * Interface de Funções de Ativação
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public interface Activation extends Serializable
{
    /**
     * Função de Ativação para Redes Neurais
     * @param d Valor de Entrada para a Função
     * @return Saída da Função
     */
    public double activate(double value);

    /**
     * Derivada da Função
     * @param d Valor de Entrada para a Função
     * @return Saída da Função
     */
    public double derivate(double value);
}
