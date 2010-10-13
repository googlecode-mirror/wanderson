package br.unisinos.cs.gp.parallax;

import java.awt.Dimension;
import javax.swing.BoxLayout;
import javax.swing.JPanel;

/**
 * Painel de Miniaturas do Editor
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorThumbnailer extends JPanel
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -8119800408738771708L;

    /**
     * Construtor da Classe
     */
    public ParallaxEditorThumbnailer()
    {
        this.setPreferredSize(new Dimension(150,0));
        this.setLayout(new BoxLayout(this, BoxLayout.Y_AXIS));
    }
}
