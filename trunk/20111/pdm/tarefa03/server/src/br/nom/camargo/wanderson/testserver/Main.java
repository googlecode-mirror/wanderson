package br.nom.camargo.wanderson.testserver;

/**
 * Classe Principal de Execução
 * @author Wanderson Henrique Camargo Rosa
 */
public class Main implements Runnable
{
    /**
     * Fluxo Inicial de Execução
     * @param args Argumentos para Inicialização
     */
    public static void main(String[] args)
    {
        Main main = new Main();
        main.run();
    }

    /**
     * Fluxo Principal de Execução
     */
    public void run()
    {
        TestServer t = new TestServer();
        try {
            t.start();
        } catch(TestServerException e) {
            e.printStackTrace();
        }
    }
}
