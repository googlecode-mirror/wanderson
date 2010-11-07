package ann.feedforward;

import java.io.*;

public class FeedForwardLoad implements Runnable
{
    public void run()
    {
        try {
            FileInputStream fis   = new FileInputStream("ann.serialize");
            ObjectInputStream ois = new ObjectInputStream(fis);
            FeedForwardNetwork network = (FeedForwardNetwork) ois.readObject();
            ois.close();
            for (FeedForwardLayer layer : network.getLayers()) {
                System.out.println(layer);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void main(String args[])
    {
        FeedForwardLoad test = new FeedForwardLoad();
        test.run();
    }
}
