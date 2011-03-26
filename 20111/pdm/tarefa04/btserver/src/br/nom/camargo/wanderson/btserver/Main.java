package br.nom.camargo.wanderson.btserver;

public class Main
{
    public static void main(String args[])
    {
        try {
            SystemOutServer server = new SystemOutServer();
            server.run();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
