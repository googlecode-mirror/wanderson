package br.unisinos.cs.gp.parallax;

import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;

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
     * Ponteiro para o Editor Parallax
     */
    private ParallaxEditor editor;

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
     * @param editor Editor Parallax em Utilização
     */
    public ParallaxEditorMenu(ParallaxEditor editor)
    {
        this.editor = editor;

        fileOpen   = new JMenuItem("Open");
        fileImport = new JMenuItem("Import");
        fileClose  = new JMenuItem("Close");
        fileQuit   = new JMenuItem("Quit");

        JMenu file = new JMenu("File");
        file.add(fileOpen);
        file.add(fileImport);
        file.add(fileClose);
        file.addSeparator();
        file.add(fileQuit);
        this.add(file);

        layerAdd = new JMenuItem("Add");
        layerRemove = new JMenuItem("Remove");

        JMenu layer = new JMenu("Layer");
        layer.add(layerAdd);
        layer.add(layerRemove);
        this.add(layer);

        filterOpen = new JMenuItem("Open");

        JMenu filter = new JMenu("Filter");
        filter.add(filterOpen);
        this.add(filter);

        helpAbout = new JMenuItem("About");

        JMenu help = new JMenu("Help");
        help.add(helpAbout);
        this.add(help);
    }

    /**
     * Encapsulamento do Editor Parallax Utilizado
     * @return Ponteiro para o Editor
     */
    public ParallaxEditor getEditor()
    {
        return editor;
    }
}
