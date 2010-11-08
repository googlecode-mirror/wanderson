package main;

import java.rmi.*;
import java.rmi.server.*;

public class Server extends UnicastRemoteObject implements ServerInterface
{
    private static final long serialVersionUID = 6218595841644859655L;

    public Server() throws RemoteException
    {
        super();
        System.out.println("Server Started");
    }

    public double add(double a, double b) throws RemoteException
    {
        System.out.println("Add");
        return a + b;
    }

    public double sub(double a, double b) throws RemoteException
    {
        System.out.println("Sub");
        return a - b;
    }

    public double mul(double a, double b) throws RemoteException
    {
        System.out.println("Mul");
        return a * b;
    }

    public double div(double a, double b) throws RemoteException
    {
        System.out.println("Div");
        return a / b;
    }

    public static void main(String args[])
    {
        try {
            Naming.bind("Server", new Server());
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

}
