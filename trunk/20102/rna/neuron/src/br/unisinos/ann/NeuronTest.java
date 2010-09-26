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
            
            double values[][] = new double[1000][2];
            for (int i = 0; i < 1000; i++) {
                values[i][0] = i / 1000.0;
                values[i][1] = Math.pow(i, 2) / 1000000.0;
            }

            System.out.println("Input Set 1");
            System.out.println("-----------");
            System.out.println();

            function = NeuronFunction.THRESHOLD;
            this.test(function, values);

            function = NeuronFunction.SIGMOID;
            this.test(function, values);

            function = NeuronFunction.HYPERBOLIC;
            this.test(function, values);

            System.out.println();

            values = new double[1000][2];
            for (int i = 0; i < 1000; i++) {
                values[i][0] = i / 1000.0;
                values[i][1] = Math.sqrt(i) / 1000000.0;
            }

            System.out.println("Input Set 2");
            System.out.println("-----------");
            System.out.println();

            function = NeuronFunction.THRESHOLD;
            this.test(function, values);

            function = NeuronFunction.SIGMOID;
            this.test(function, values);

            function = NeuronFunction.HYPERBOLIC;
            this.test(function, values);

            System.out.println();

            neuron = new Neuron(3);

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

            double triangle[][] = new double[100][3];
            for (int i = 0; i < 100; i++) {
                triangle[i][0] = i / 10;
                triangle[i][1] = i % 10;
                triangle[i][2] = Math.sqrt(Math.pow(triangle[i][0], 2) + Math.pow(triangle[i][1], 2));
            }

            System.out.println("Input Set 3");
            System.out.println("-----------");
            System.out.println();

            function = NeuronFunction.THRESHOLD;
            this.triangle(function, triangle);

            function = NeuronFunction.SIGMOID;
            this.triangle(function, triangle);

            function = NeuronFunction.HYPERBOLIC;
            this.triangle(function, triangle);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void test(NeuronFunction function, double values[][]) throws AnnException
    {
        double inputs[];
        double result;
        for (int i = 0; i < 1000; i++) {
            inputs    = new double[2];
            inputs[0] = values[i][0];
            inputs[1] = values[i][1];
            result = neuron.activate(function, inputs);
            System.out.printf("%s (%.3f,%.6f) = %.16f\n", function, values[i][0], values[i][1], result);
        }
    }

    private void triangle(NeuronFunction function, double values[][]) throws AnnException
    {
        double result;
        for (int i = 0; i < 100; i++) {
            result = neuron.activate(function, values[i]);
            System.out.printf("%s (%.0f,%.0f,%.8f) = %.16f\n", function, values[i][0], values[i][1], values[i][2], result);
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
