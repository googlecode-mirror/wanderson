package main;

import java.rmi.*;

public class Client
{
    private ServerInterface server;

    public Client()
    {
        try {
            this.server =
                (ServerInterface) Naming.lookup("rmi://127.0.0.1/Server");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public double area(double a, double b) throws RemoteException
    {
        return this.server.mul(a, b);
    }

    public static void main(String args[])
    {
        try {
            Client client = new Client();
            double area = client.area(10, 5);
            System.out.println("Area: " + area);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
