package ann.feedforward;

public class FeedForwardTest implements Runnable
{
    public void run()
    {
        FeedForwardNetwork network = new FeedForwardNetwork();

        network
            .addLayer(new FeedForwardLayer(3))
            .addLayer(new FeedForwardLayer(2))
            .addLayer(new FeedForwardLayer(3));

        network.reset();
        System.out.println(this.format(network.getOutputLayer().getFire()));

        double result[];

        double pattern1[] = {1,2,3};
        result = network.computeOutputs(pattern1);
        System.out.println(this.format(result));

        result = network.computeOutputs(pattern1);
        System.out.println(this.format(result));
    }

    public String format(double vector[])
    {
        StringBuilder builder = new StringBuilder();
        builder.append("[");
        for (int i = 0; i < vector.length; i++) {
            builder.append(vector[i]);
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
