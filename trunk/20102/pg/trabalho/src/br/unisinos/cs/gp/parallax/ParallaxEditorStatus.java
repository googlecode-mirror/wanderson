package br.unisinos.cs.gp.parallax;

import java.awt.Dimension;
import javax.swing.JLabel;
import javax.swing.JPanel;
import java.awt.BorderLayout;
import javax.swing.BorderFactory;

/**
 * Barra de Status da Janela do Editor
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorStatus extends JPanel
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 7897012902945839768L;

    /**
     * Mensagem de Exibição
     */
    private JLabel message;

    /**
     * Construtor da Classe
     */
    public ParallaxEditorStatus()
    {
        this.message = new JLabel();
        this.setPreferredSize(new Dimension(0, 25));
        this.setLayout(new BorderLayout());
        this.setBorder(BorderFactory.createLoweredBevelBorder());
        this.add(message, BorderLayout.WEST);
    }

    /**
     * Configuração da Mensagem de Exibição
     * @param message Novo Valor para Incluir na Barra de Status
     * @return Próprio Objeto
     */
    public ParallaxEditorStatus setMessage(String message)
    {
        this.message.setText(message);
        return this;
    }
}
