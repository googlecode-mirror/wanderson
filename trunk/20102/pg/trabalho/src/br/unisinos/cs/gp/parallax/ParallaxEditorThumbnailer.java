package br.unisinos.cs.gp.parallax;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;

import javax.swing.BoxLayout;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

/**
 * Painel de Miniaturas do Editor
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorThumbnailer extends JPanel implements ActionListener
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
        properties.setLayout(new GridLayout(2,1));
        this.add(properties, BorderLayout.PAGE_END);
        speed = new JTextField();
        JLabel label = new JLabel("Speed");
        label.setLabelFor(speed);
        properties.add(label);
        properties.add(speed);
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
}
