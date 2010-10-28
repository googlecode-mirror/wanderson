package br.unisinos.cs.gp.parallax;

import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.event.MenuEvent;

/**
 * Menu Principal da Janela do Editor Parallax
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorMenu extends JMenuBar
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 3037194320383355872L;

    /**
     * Elemento de Abertura de Projetos
     */
    private JMenuItem fileOpen;

    /**
     * Importação de Imagens para a Camada
     */
    private JMenuItem fileImport;

    /**
     * Fechar o Arquivo Atual
     */
    private JMenuItem fileClose;

    /**
     * Sair do Aplicativo
     */
    private JMenuItem fileQuit;

    /**
     * Adicionar Camada
     */
    private JMenuItem layerAdd;

    /**
     * Remover Camada Atual
     */
    private JMenuItem layerRemove;

    /**
     * Abrir Filtro
     */
    private JMenuItem filterOpen;

    /**
     * Sobre o Aplicativo
     */
    private JMenuItem helpAbout;

    /**
     * Construtor da Classe
     */
    public ParallaxEditorMenu()
    {
        fileOpen   = new JMenuItem("Open");  fileOpen.setEnabled(false);
        fileClose  = new JMenuItem("Close"); fileClose.setEnabled(false);
        fileQuit   = new JMenuItem("Quit");
        fileQuit.addMouseListener(new QuitAction());

        JMenu file = new JMenu("File");
        file.add(fileOpen);
        file.add(fileClose);
        file.addSeparator();
        file.add(fileQuit);
        this.add(file);

        layerAdd = new JMenuItem("Add");
        layerAdd.addMouseListener(new AddAction());
        layerRemove = new JMenuItem("Remove");  layerRemove.setEnabled(false);

        JMenu layer = new JMenu("Layer");
        layer.add(layerAdd);
        layer.add(layerRemove);
        this.add(layer);

        filterOpen = new JMenuItem("Open");

        JMenu filter = new JMenu("Filter");
        filter.add(filterOpen);
        this.add(filter);
        filter.setEnabled(false);
    }

    class AddAction extends MouseAdapter
    {
        public void mouseClicked(MouseEvent e)
        {
            ParallaxEditor.getInstance().openImage();
        }
    }

    class QuitAction extends MouseAdapter
    {
        public void mouseClicked(MouseEvent e)
        {
            ParallaxEditor.getInstance().quit();
        }
    }
}
