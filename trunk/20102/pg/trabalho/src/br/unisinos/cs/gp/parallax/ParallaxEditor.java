package br.unisinos.cs.gp.parallax;

import java.io.File;
import javax.swing.JFrame;
import java.awt.BorderLayout;
import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;

/**
 * Tela Principal do Editor
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditor extends JFrame
{
    /**
     * Número para Serialização
     */
    private static final long serialVersionUID = -3188022712272854278L;

    /**
     * Visualiazação
     */
    private ViewPort viewPort;

    /**
     * Menu Principal
     */
    private ParallaxEditorMenu menu;

    /**
     * Barra de Status da Janela
     */
    private ParallaxEditorStatus status;

    /**
     * Barra de Ferramentas
     */
    private ParallaxEditorToolbar toolbar;

    /**
     * Construtor da Classe
     */
    public ParallaxEditor()
    {
        super("Parallax Editor");

        viewPort = new ViewPort(this);
        status   = new ParallaxEditorStatus();
        menu     = new ParallaxEditorMenu(this);
        toolbar  = new ParallaxEditorToolbar(this);

        this.setJMenuBar(menu);
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setSize(800, 600);

        this.setLayout(new BorderLayout());
        this.add(viewPort, BorderLayout.CENTER);
        this.add(status, BorderLayout.PAGE_END);
        this.add(toolbar, BorderLayout.PAGE_START);
    }

    /**
     * Encapsulamento de Acesso da Visualização
     * @return Visualização Solicitada
     */
    public ViewPort getViewPort()
    {
        return viewPort;
    }

    /**
     * Método Principal de Execução para Testes
     * @param args Argumentos de Entrada
     * @throws Exception Erros Encontrados
     */
    public static void main(String args[]) throws Exception
    {
        ParallaxEditor editor = new ParallaxEditor();
        BufferedImage image = ImageIO.read(new File("data/bird_256.png"));
        Layer layer = new Layer(image.getWidth(), image.getHeight());
        layer.setData(image.getData());
        editor.getViewPort().getLayerSet().add(layer);
        editor.setVisible(true);
    }
}
