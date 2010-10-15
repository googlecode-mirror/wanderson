package br.unisinos.cs.gp.parallax;

import java.awt.Color;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.util.ArrayList;

import javax.swing.JFrame;

public class ParallaxPlayer extends JFrame implements KeyListener
{
    private static final long serialVersionUID = -1388811758060849434L;

    private ArrayList<Layer> list;

    public ParallaxPlayer()
    {
        this.setSize(new Dimension(640, 480));
        this.list = new ArrayList<Layer>();

        Container pane = this.getContentPane();
        pane.setBackground(Color.BLACK);
        this.addKeyListener(this);
    }

    public ParallaxPlayer addLayer(Layer layer)
    {
        this.list.add(layer);
        return this;
    }

    public void paint(Graphics g)
    {
        super.paint(g);
        for (Layer layer : list) {
            g.drawImage(layer, layer.getX(), layer.getY(), this);
        }
    }

    public void keyPressed(KeyEvent event)
    {
        for (Layer layer : list) {
            switch (event.getKeyCode()) {
                case KeyEvent.VK_RIGHT:
                    layer.setX((layer.getX() + layer.getSpeed()) / 1.0);
                    break;
                case KeyEvent.VK_LEFT:
                    layer.setX((layer.getX() - layer.getSpeed()) / 1.0);
                    break;
            }
            this.repaint();
        }
    }

    public void keyReleased(KeyEvent event)
    {
        
    }

    public void keyTyped(KeyEvent event)
    {
        
    }
}
