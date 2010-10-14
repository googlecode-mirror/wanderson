package br.unisinos.cs.gp.parallax;

import java.net.URL;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JToolBar;
import javax.swing.BorderFactory;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;

/**
 * Barra de Ferramentas do Editor Parallax
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorToolbar extends JToolBar
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 8885156170212969419L;

    /**
     * Abertura de Projeto
     */
    private JButton buttonOpen;

    /**
     * Salvar Projeto Atual
     */
    private JButton buttonSave;

    /**
     * Adicionar Camada
     */
    private JButton buttonAdd;

    /**
     * Remover Camada Atual
     */
    private JButton buttonRemove;

    private JButton buttonPlay;

    /**
     * Construtor da Classe
     */
    public ParallaxEditorToolbar()
    {
        this.setFloatable(false);
        this.setBorder(BorderFactory.createRaisedBevelBorder());

        URL image;

        image = this.getClass().getResource("resource/48px_open.png");
        buttonOpen = new JButton(new ImageIcon(image));
        this.add(buttonOpen);

        image = this.getClass().getResource("resource/48px_save.png");
        buttonSave = new JButton(new ImageIcon(image));
        this.add(buttonSave);

        this.addSeparator();

        image = this.getClass().getResource("resource/48px_add.png");
        buttonAdd = new JButton(new ImageIcon(image));
        buttonAdd.addMouseListener(new AddAction());
        this.add(buttonAdd);

        image = this.getClass().getResource("resource/48px_remove.png");
        buttonRemove = new JButton(new ImageIcon(image));
        this.add(buttonRemove);

        this.addSeparator();

        image = this.getClass().getResource("resource/48px_play.png");
        buttonPlay = new JButton(new ImageIcon(image));
        buttonPlay.addMouseListener(new PlayAction());
        this.add(buttonPlay);
    }

    /**
     * Ação de Abertura de Arquivos
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    public class AddAction extends MouseAdapter
    {
        public void mouseClicked(MouseEvent e)
        {
            ParallaxEditor editor = ParallaxEditor.getInstance();
            editor.openImage();
        }
    }

    public class PlayAction extends MouseAdapter
    {
        public void mouseClicked(MouseEvent e)
        {
            ParallaxEditor.getInstance().play();
        }
    }
}
