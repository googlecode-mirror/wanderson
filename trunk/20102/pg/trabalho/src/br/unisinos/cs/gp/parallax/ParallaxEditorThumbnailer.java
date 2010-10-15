package br.unisinos.cs.gp.parallax;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;

import javax.swing.BoxLayout;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

/**
 * Painel de Miniaturas do Editor
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorThumbnailer extends JPanel implements ActionListener, MouseListener
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -8119800408738771708L;

    private JPanel thumbview;

    private JTextField speed;

    /**
     * Construtor da Classe
     */
    public ParallaxEditorThumbnailer()
    {
        this.setPreferredSize(new Dimension(150,0));
        this.setLayout(new BorderLayout());

        thumbview = new JPanel();
        thumbview.setLayout(new BoxLayout(thumbview, BoxLayout.Y_AXIS));
        this.add(thumbview, BorderLayout.CENTER);

        JPanel properties = new JPanel();
        properties.setBackground(Color.WHITE);
        properties.setPreferredSize(new Dimension(150,150));
        properties.setLayout(new GridLayout(3,1));
        this.add(properties, BorderLayout.PAGE_END);
        speed = new JTextField();
        JLabel label = new JLabel("Speed");
        JButton apply = new JButton("Apply Speed");
        apply.addMouseListener(this);
        label.setLabelFor(speed);
        properties.add(label);
        properties.add(speed);
        properties.add(apply);
        speed.setEnabled(false);
        speed.addActionListener(this);
    }

    /**
     * Adiciona uma Miniatura ao Visualizador
     * @param Camada da Visualização
     * @return Próprio Objeto
     */
    public ParallaxEditorThumbnailer addLayer(Layer layer)
    {
        ParallaxEditorThumb thumb = new ParallaxEditorThumb(this);
        thumb.setImage(layer);
        this.thumbview.add(thumb);
        return this;
    }

    public ParallaxEditorThumbnailer updateSpeed(double speed)
    {
        this.speed.setText("" + speed);
        this.speed.setEnabled(true);
        return this;
    }

    @Override
    public void actionPerformed(ActionEvent action)
    {
        int index = ParallaxEditor.getInstance().getViewPort().getCurrentIndex();
        double speed = Double.parseDouble(this.speed.getText());
        ParallaxEditor.getInstance().getViewPort().getLayerSet().get(index).setSpeed(speed);
    }

    @Override
    public void mouseClicked(MouseEvent arg0) {
        this.actionPerformed(null);
        
    }

    @Override
    public void mouseEntered(MouseEvent arg0) {
        // TODO Auto-generated method stub
        
    }

    @Override
    public void mouseExited(MouseEvent arg0) {
        // TODO Auto-generated method stub
        
    }

    @Override
    public void mousePressed(MouseEvent arg0) {
        // TODO Auto-generated method stub
        
    }

    @Override
    public void mouseReleased(MouseEvent arg0) {
        // TODO Auto-generated method stub
        
    }
}
