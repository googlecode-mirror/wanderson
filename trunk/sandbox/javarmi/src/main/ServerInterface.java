package main;

import java.rmi.*;

public interface ServerInterface extends Remote
{
    public double add(double a, double b) throws RemoteException;
    public double sub(double a, double b) throws RemoteException;
    public double mul(double a, double b) throws RemoteException;
    public double div(double a, double b) throws RemoteException;
}
