package br.nom.camargo.wanderson.presenter;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.util.Observable;
import java.util.Observer;

import javax.swing.BorderFactory;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;

public class PresenterView extends JFrame implements Observer
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -3018980289724185784L;
    private JStatusBar status;

    /**
     * Construtor
     */
    public PresenterView()
    {
        super(); init();
        setStatusMessage("Ready");
    }

    /**
     * Inicialização dos Componentes
     * @return Próprio Objeto para Encadeamento
     */
    private PresenterView init()
    {
        /* Janela */
        Dimension d = new Dimension(300,400);
        setSize(d);
        setPreferredSize(d);
        setResizable(false);

        /* Status */
        status = new JStatusBar();
        add(status, BorderLayout.PAGE_END);

        return this;
    }

    public PresenterView setStatusMessage(String message)
    {
        status.setMessage(message);
        return this;
    }

    public void update(Observable o, Object arg)
    {
        
    }

    public class JStatusBar extends JPanel
    {
        private JLabel message;
        private static final long serialVersionUID = -2831849678412866272L;
        public JStatusBar()
        {
            super(); init();
        }
        private JStatusBar init()
        {
            /* Local */
            setBorder(BorderFactory.createLoweredBevelBorder());
            setLayout(new BorderLayout());

            /* Mensagem */
            message = new JLabel();
            add(message, BorderLayout.WEST);

            return this;
        }
        public JStatusBar setMessage(String m)
        {
            message.setText(m);
            return this;
        }
    }
}
