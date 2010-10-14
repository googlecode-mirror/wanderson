package br.unisinos.cs.gp.parallax;

import java.awt.Dimension;

import javax.swing.JFrame;

public class ParallaxPlayer extends JFrame
{
    private static final long serialVersionUID = -1388811758060849434L;

    private ViewPort viewPort;

    public ParallaxPlayer(ViewPort viewPort)
    {
        this.viewPort = viewPort;
        this.add(viewPort);
        this.setSize(new Dimension(640, 480));
    }
}
