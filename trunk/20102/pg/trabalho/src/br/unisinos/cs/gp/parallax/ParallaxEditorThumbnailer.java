package br.unisinos.cs.gp.parallax;

import java.awt.Dimension;
import javax.swing.BoxLayout;
import javax.swing.JPanel;

public class ParallaxEditorThumbnailer extends JPanel
{
    private static final long serialVersionUID = -8119800408738771708L;

    private ParallaxEditor editor;

    public ParallaxEditorThumbnailer(ParallaxEditor editor)
    {
        this.editor = editor;
        this.setPreferredSize(new Dimension(150,0));
        this.setLayout(new BoxLayout(this, BoxLayout.Y_AXIS));

    }

    public ParallaxEditor getEditor()
    {
        return this.editor;
    }
}
