package br.unisinos.cs.gp.parallax;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;

import javax.swing.JFrame;
import java.awt.BorderLayout;
import javax.swing.JFileChooser;
import java.awt.image.BufferedImage;
import br.unisinos.cs.gp.image.ImageLoader;
import br.unisinos.cs.gp.image.handler.ImageHandlerException;

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
     * Instância Privada para Padrão de Projeto Singleton
     */
    private static ParallaxEditor instance;

    /**
     * Visualização
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
     * Painel de Miniaturas
     */
    private ParallaxEditorThumbnailer thumbnailer;

    /**
     * Construtor da Classe
     */
    private ParallaxEditor()
    {
        super("Parallax Editor");

        viewPort    = new ViewPort();
        status      = new ParallaxEditorStatus();
        menu        = new ParallaxEditorMenu();
        toolbar     = new ParallaxEditorToolbar();
        thumbnailer = new ParallaxEditorThumbnailer();

        this.setJMenuBar(menu);
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setSize(800, 600);

        this.setLayout(new BorderLayout());
        this.add(viewPort, BorderLayout.CENTER);
        this.add(status, BorderLayout.PAGE_END);
        this.add(toolbar, BorderLayout.PAGE_START);
        this.add(thumbnailer, BorderLayout.LINE_START);
    }

    /**
     * Padrão de Projeto Singleton
     * Garante uma única instância do objeto na memória
     * Centraliza configurações do editor conforme necessidade em outras classes
     * @return A única instância do editor na memória
     */
    public static ParallaxEditor getInstance()
    {
        if (ParallaxEditor.instance == null) {
            ParallaxEditor.instance = new ParallaxEditor();
        }
        return ParallaxEditor.instance;
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
     * Encapsulamento de Acesso às Miniaturas
     * @return Painel de Miniaturas
     */
    public ParallaxEditorThumbnailer getThumbnailer()
    {
        return thumbnailer;
    }

    /**
     * Abrir Arquivo no Editor
     * @return Próprio Objeto
     */
    public ParallaxEditor openImage()
    {
        ParallaxEditorImageChooser chooser = new ParallaxEditorImageChooser();
        int option = chooser.showOpenDialog(this);
        if (option == JFileChooser.APPROVE_OPTION) {
            File archive = chooser.getSelectedFile();
            try {
                /*
                 * Carrega Imagem de Arquivo -----------------------------------
                 */
                BufferedImage image = ImageLoader.factory(
                    archive.getAbsolutePath(), chooser.getType());

                /*
                 * Adiciona Visualização na ViewPort ---------------------------
                 */
                Layer layer = new Layer(image.getWidth(), image.getHeight());
                for (int j = 0; j < image.getHeight(); j++) {
                    for (int i = 0; i < image.getWidth(); i++) {
                        layer.setRGB(i, j, image.getRGB(i, j));
                    }
                }
                this.getViewPort().getLayerSet().add(layer);
                this.getViewPort().repaint();

                /*
                 * Criar Miniaturas --------------------------------------------
                 */
                this.getThumbnailer().addLayer(layer);
                this.getThumbnailer().repaint();

                this.status.setMessage("Complete");

                if (this.getViewPort().getLayerSet().size() > 0) {
                    layer = this.getViewPort().getLayerSet()
                        .get(this.getViewPort().getCurrentIndex());
                    this.getThumbnailer().updateSpeed(layer.getSpeed());
                }

            } catch (ImageHandlerException e) {
                this.status.setMessage(e.getMessage());
            }
        }
        return this;
    }

    public ParallaxEditor play()
    {
        ParallaxPlayer player = new ParallaxPlayer();
        for (Layer layer : this.getViewPort().getLayerSet()) {
            player.addLayer(layer.clone());
        }
        player.setVisible(true);
        player.setDefaultCloseOperation(ParallaxPlayer.DISPOSE_ON_CLOSE);
        return this;
    }

    public ParallaxEditor save()
    {
        FileOutputStream fos = null;
        ObjectOutputStream oos = null;
        try {
            fos = new FileOutputStream(new File("teste.plx"));
            oos = new ObjectOutputStream(fos);
            oos.writeObject(this.getViewPort());
            oos.close();
        } catch (IOException e) {
            e.printStackTrace();
            this.status.setMessage("Save Exception");
        }
        this.status.setMessage("Saved");
        return this;
    }

    public ParallaxEditor open()
    {
        FileInputStream fis = null;
        ObjectInputStream ois = null;
        try {
            fis = new FileInputStream(new File("teste.plx"));
            ois = new ObjectInputStream(fis);
            Object o = ois.readObject();
//            this.viewPort = (ViewPort) ois.readObject();
            ois.close();
        } catch (IOException e) {
            e.printStackTrace();
            this.status.setMessage("Open Exception");
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
        this.status.setMessage("Opened");
        return this;
    }

    public ParallaxEditor quit()
    {
        System.exit(0);
        return this;
    }

    /**
     * Método Principal de Execução para Testes
     * @param args Argumentos de Entrada
     * @throws Exception Erros Encontrados
     */
    public static void main(String args[]) throws Exception
    {
        ParallaxEditor editor = ParallaxEditor.getInstance();
        editor.setVisible(true);
    }
}
