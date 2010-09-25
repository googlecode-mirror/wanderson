package br.unisinos.cs.gp.parallax;

import java.net.URL;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JToolBar;
import javax.swing.BorderFactory;

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
     * Ponteiro para o Editor Parallax
     */
    private ParallaxEditor editor;

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

    /**
     * Construtor da Classe
     * @param editor Editor Parallax Relacionado
     */
    public ParallaxEditorToolbar(ParallaxEditor editor)
    {
        URL image;
        this.editor = editor;
        this.setFloatable(false);
        this.setBorder(BorderFactory.createRaisedBevelBorder());

        image = this.getClass().getResource("resource/48px_open.png");
        buttonOpen = new JButton(new ImageIcon(image));
        this.add(buttonOpen);

        image = this.getClass().getResource("resource/48px_save.png");
        buttonSave = new JButton(new ImageIcon(image));
        this.add(buttonSave);

        this.addSeparator();

        image = this.getClass().getResource("resource/48px_add.png");
        buttonAdd = new JButton(new ImageIcon(image));
        this.add(buttonAdd);

        image = this.getClass().getResource("resource/48px_remove.png");
        buttonRemove = new JButton(new ImageIcon(image));
        this.add(buttonRemove);
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
