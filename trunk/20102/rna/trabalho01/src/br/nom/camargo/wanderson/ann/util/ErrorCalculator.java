package br.nom.camargo.wanderson.ann.util;

/**
 * Calculadora de Erros
 * @author Wanderson Henrique Camargo Rosa
 */
public class ErrorCalculator
{
    /**
     * Instância Singleton
     */
    private static ErrorCalculator instance = null;

    /**
     * Valor de Erro Global
     */
    private double global;

    /**
     * Número de Elementos Processados
     */
    private double size;

    /**
     * Construtor Padrão
     * Método Singleton
     */
    private ErrorCalculator()
    {
        this.reset();
    }

    /**
     * Acesso à Instância Singleton
     * @return Objeto Único na Memória
     */
    public static ErrorCalculator getInstance()
    {
        if (ErrorCalculator.instance == null) {
            ErrorCalculator.instance = new ErrorCalculator();
        }
        return ErrorCalculator.instance;
    }

    /**
     * Reinicialização do Cálculo de Erros
     * @return Próprio Objeto para Encadeamento
     */
    public ErrorCalculator reset()
    {
        this.global = 0;
        this.size   = 0;
        return this;
    }

    /**
     * Cálculo de Erro para Escalares
     * @param current Valor Atual
     * @param ideal Valor Ideal
     * @return Próprio Objeto para Encadeamento
     */
    private ErrorCalculator update(double current, double ideal)
    {
        double delta = ideal - current;
        this.global  = this.global + Math.pow(delta, 2);
        this.size    = this.size + 1;
        return this;
    }

    /**
     * Cálculo de Erro para Entradas Múltiplas
     * @param current Valores Atuais
     * @param ideal Valores Ideais
     * @return
     */
    public ErrorCalculator update(double current[], double ideal[])
    {
        for (int i = 0; i < current.length; i++) {
            this.update(current[i], ideal[i]);
        }
        return this;
    }

    /**
     * Root Mean Square Error
     * @return Valor do Cálculo de Erro
     */
    public double rms()
    {
        return Math.sqrt(this.global / this.size);
    }
}
