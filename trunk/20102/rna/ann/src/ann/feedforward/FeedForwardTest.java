package ann.feedforward;

import java.io.*;
import java.text.*;
import ann.feedforward.backpropagation.*;

public class FeedForwardTest implements Runnable
{
    public void run()
    {
        FeedForwardNetwork network = new FeedForwardNetwork();

        network
            .addLayer(new FeedForwardLayer(2))
            .addLayer(new FeedForwardLayer(3))
            .addLayer(new FeedForwardLayer(1));
        network.reset();

        System.out.println("Neural Network");
        for (FeedForwardLayer layer : network.getLayers()) {
            System.out.println(layer);
        }

        double learn = 0.7;
        double momentum = 0.9;
        double pattern[][] = {{0,0},{0,1},{1,0},{1,1}};
        double ideal[][]   = {{0},{1},{1},{0}};

        BackPropagation bp
            = new BackPropagation(network, pattern, ideal, learn, momentum);
        int epoch = 1;
        do {
            bp.iterate();
            System.out.printf("Epoch #%4d: Error %.16f\n", epoch, bp.getError());
            epoch = epoch + 1;
        } while (bp.getError() > 0.001);

        System.out.println("Results");
        double actual[];
        for (int i = 0; i < pattern.length; i++) {
            actual = network.computeOutputs(pattern[i]);
            System.out.printf("%s : %s\n", this.format(pattern[i]), this.format(actual));
        }
        for (FeedForwardLayer layer : network.getLayers()) {
            System.out.println(layer);
        }

        System.out.println("Serialize");
        try {
            FileOutputStream fos   = new FileOutputStream("ann.serialize");
            ObjectOutputStream oos = new ObjectOutputStream(fos);
            oos.writeObject(network);
            oos.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        System.out.println("Done.");
    }

    public String format(double vector[])
    {
        DecimalFormat format = new DecimalFormat("0.0000000000000000");
        StringBuilder builder = new StringBuilder();
        builder.append("[");
        for (int i = 0; i < vector.length; i++) {
            builder.append(format.format(vector[i]));
            if (i != vector.length - 1) {
                builder.append(",");
            }
        }
        builder.append("]");
        return builder.toString();
    }

    public static void main(String args[])
    {
        FeedForwardTest test = new FeedForwardTest();
        test.run();
    }
}
