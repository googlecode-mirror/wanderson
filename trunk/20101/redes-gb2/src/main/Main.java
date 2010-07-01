package main;

public class Main
{
    public static void main(String args[]) throws Exception
    {
        if (args.length < 2) {
            throw new Exception("Usage: main (server port|client address:port)");
        }
        machine.Machine machine;
        if (args[0].toLowerCase().equals("server")) {
            machine = new machine.Server(Integer.parseInt(args[1]));
        } else if (args[0].toLowerCase().equals("client")) {
            machine = new machine.Client(args[1]);
            for (int i = 0; i < 11; i++) {
                machine.buffer(Integer.toString(i));
            }
            machine.forceError(5);
        } else {
            throw new Exception("Usage: main (server port|client address:port)");
        }
        machine.start(args[0]);
    }
}
