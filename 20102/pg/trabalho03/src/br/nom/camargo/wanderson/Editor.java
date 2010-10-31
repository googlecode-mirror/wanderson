package br.nom.camargo.wanderson;

import java.awt.*;
import javax.swing.*;

/**
 * Janela de Edição
 * Aplicação do Algoritmo Bresenhan e Derivados
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class Editor extends JFrame implements Runnable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -3853437962877352668L;

    /**
     * Instância Única do Objeto
     * Padrão de Projeto Singleton
     */
    private static Editor instance;

    /**
     * Objeto de Desenho
     */
    protected Canvas canvas;

    /**
     * Construtor Padrão
     * Padrão de Projeto Singleton
     */
    private Editor()
    {
        super("Bresenhan Editor");
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setSize(640, 480);

        this.canvas = new Canvas();
        this.add(this.canvas);

        Dimension screen = Toolkit.getDefaultToolkit().getScreenSize();
        int x = (screen.width - this.getWidth()) /2;
        int y = (screen.height - this.getHeight()) / 2;
        this.setLocation(x, y);
    }

    /**
     * Acesso ao Objeto Único de Memória
     * Padrão de Projeto Singleton
     * @return Objeto Singleton
     */
    public static Editor getInstance()
    {
        if (Editor.instance == null) {
            Editor.instance = new Editor();
        }
        return Editor.instance;
    }

    /**
     * Acesso ao Objeto de Desenho
     * @return Objeto de Encapsulamento de Desenho
     */
    public Canvas getCanvas()
    {
        return this.canvas;
    }

    /**
     * Método Principal de Execução do Aplicativo
     */
    public void run()
    {
        this.setVisible(true);
    }

    /**
     * Método de Execução do Ambiente
     * @param args Parâmetros de Entrada
     */
    public static void main(String args[])
    {
        Editor editor = Editor.getInstance();
        editor.run();
        editor.getCanvas().circle(10, 10, 10).fill(15,15).update();
    }
}
