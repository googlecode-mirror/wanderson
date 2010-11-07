package ann.util;

/**
 * Calculadora de Erros
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ErrorCalculator
{
    /**
     * Instância Única
     * Singleton Pattern
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
     * Informa a Instância Única de Calculadora de Erro
     * Singleton Pattern
     * @return Objeto Único
     */
    public static ErrorCalculator getInstance()
    {
        if (ErrorCalculator.instance == null) {
            ErrorCalculator.instance = new ErrorCalculator();
        }
        return ErrorCalculator.instance;
    }

    /**
     * Construtor Padrão
     * Acessível Somente pelo Método Singleton
     */
    private ErrorCalculator()
    {
        this.reset();
    }

    /**
     * Limpeza dos Contadores de Erro
     * @return Próprio Objeto para Encadeamento
     */
    public ErrorCalculator reset()
    {
        this.global = 0;
        this.size   = 0;
        return this;
    }

    /**
     * Atualização do Erro para Único Elemento
     * @param actual Valor Atuais
     * @param ideal  Valor Ideais
     * @return Próprio Objeto para Encadeamento
     */
    public ErrorCalculator update(double actual, double ideal)
    {
        double delta = ideal - actual;
        this.global += Math.pow(delta, 2);
        this.size   += 1;
        return this;
    }

    /**
     * Atualização do Erro para Conjunto de Elementos
     * @param actual Valores Atuais
     * @param ideal  Valores Ideais
     * @return Próprio Objeto para Encadeamento
     */
    public ErrorCalculator update(double actual[], double ideal[])
    {
        for (int i = 0; i < actual.length; i++) {
            this.update(actual[i], ideal[i]);
        }
        return this;
    }

    /**
     * Root Mean Square Error
     * @return Valor Calculado
     */
    public double rms()
    {
        return Math.sqrt(this.global / this.size);
    }
}
