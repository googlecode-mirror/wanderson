package br.unisinos.cs.gp.parallax;

import java.awt.Color;
import java.awt.Graphics;
import javax.swing.JPanel;
import java.util.ArrayList;
import java.awt.event.MouseEvent;
import java.awt.event.MouseMotionListener;

/**
 * Visualização das Camadas
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ViewPort extends JPanel implements MouseMotionListener
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -5933819053292295976L;

    /**
     * Ponteiro ao Editor Parallax
     */
    private ParallaxEditor editor;

    /**
     * Conjunto de Camadas Utilizadas
     */
    private ArrayList<Layer> layerSet;

    /**
     * Valor Chave da Camada Atual do Conjunto
     */
    private int current;

    /**
     * Construtor da Classe
     * @param editor Editor Parallax
     */
    public ViewPort(ParallaxEditor editor)
    {
        this.editor = editor;
        this.layerSet = new ArrayList<Layer>();

        this.setBackground(Color.BLACK);
        this.addMouseMotionListener(this);
    }

    /**
     * Encapsulamento de Acesso ao Editor Parallax
     * @return Ponteiro para o Editor
     */
    public ParallaxEditor getEditor()
    {
        return this.editor;
    }

    /**
     * Encapsulamento de Acesso ao Conjunto de Camadas
     * @return Ponteiro para o Conjunto
     */
    public ArrayList<Layer> getLayerSet()
    {
        return this.layerSet;
    }

    /**
     * Configuração da Chave da Camada Atual no Conjunto
     * @param index Número da Chave da Camada
     * @return Próprio Objeto
     */
    public ViewPort setCurrentIndex(int index)
    {
        this.current = index;
        return this;
    }

    /**
     * Encapsulamento de Acesso ao Valor da Chave da Camada Atual
     * @return Número da Camada Atual
     */
    public int getCurrentIndex()
    {
        return this.current;
    }

    /**
     * Desenha as Camadas no Painel de Visualização
     */
    public void paint(Graphics g)
    {
        super.paint(g);
        for (Layer layer : layerSet) {
            g.drawImage(layer, layer.getX(), layer.getY(), this);
        }
    }

    /**
     * Movimenta a Imagem da Camada Atual pela Visualização
     */
    public void mouseDragged(MouseEvent event)
    {
        Layer layer = this.getLayerSet().get(current);
        if (layer != null) {
            layer.setX(event.getX() - layer.getWidth() /2);
            layer.setY(event.getY() - layer.getHeight() /2);
            this.repaint();
        }
    }

    public void mouseMoved(MouseEvent event)
    {
        
    }
}
