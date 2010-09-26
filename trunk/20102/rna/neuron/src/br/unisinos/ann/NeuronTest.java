package br.unisinos.ann;

/**
 * Testes para Neurônio Artificial
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class NeuronTest implements Runnable
{
    /**
     * Neurônio para Testes
     */
    protected Neuron neuron;

    /**
     * Execução do Aplicativo
     */
    public void run()
    {
        try {

            NeuronFunction function;

            neuron = new Neuron(2);
            double values[][] = new double[100][2];
            for (int i = 0; i < 100; i++) {
                values[i][0] = i / 100.0;
                values[i][1] = Math.pow(i, 2) / 10000.0;
            }

            System.out.println("ARTIFICIAL NEURON TEST");
            System.out.println("======================");
            System.out.println();
            System.out.println("Weights");
            System.out.println("-------");
            System.out.println();
            for (double w : neuron.getWeights()) {
                System.out.printf("%.10f\n", w);
            }
            System.out.println();

            System.out.println("Input Set 1");
            System.out.println("-----------");
            System.out.println();

            function = NeuronFunction.THRESHOLD;
            this.test(function, values);

            function = NeuronFunction.SIGMOID;
            this.test(function, values);

            function = NeuronFunction.HYPERBOLIC;
            this.test(function, values);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void test(NeuronFunction function, double values[][]) throws AnnException
    {
        double inputs[];
        double result;
        for (int i = 0; i < 100; i++) {
            inputs    = new double[2];
            inputs[0] = values[i][0];
            inputs[1] = values[i][1];
            result = neuron.activate(function, inputs);
            System.out.printf("%s (%.2f,%.4f) = %.16f\n", function, values[i][0], values[i][1], result);
        }
    }

    /**
     * Método Principal de Execução
     * @param args Argumentos de Entrada
     */
    public static void main(String args[])
    {
        NeuronTest test = new NeuronTest();
        test.run();
    }
}
