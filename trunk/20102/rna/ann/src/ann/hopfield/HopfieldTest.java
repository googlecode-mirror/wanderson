package ann.hopfield;

public class HopfieldTest implements Runnable
{
    public void run()
    {
        Hopfield hopfield = new Hopfield(4);

        double pattern1[] = {-1,1,-1,1};
        double pattern2[] = {1,-1,1,-1};
        double result[];

        System.out.println("Training Hopfield Network: " + this.format(pattern1));
        hopfield.train(pattern1);

        System.out.println("Presenting Pattern: " + this.format(pattern1));
        result = hopfield.present(pattern1);
        System.out.println("Hopfield Network Returns: " + this.format(result));

        System.out.println("Presenting Pattern: " + this.format(pattern2));
        result = hopfield.present(pattern2);
        System.out.println("Hopfield Network Returns: " + this.format(result));
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
        HopfieldTest test = new HopfieldTest();
        test.run();
    }
}
