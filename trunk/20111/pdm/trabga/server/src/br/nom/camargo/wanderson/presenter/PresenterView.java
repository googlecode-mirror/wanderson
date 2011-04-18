package br.nom.camargo.wanderson.presenter;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.Observable;
import java.util.Observer;

import javax.swing.BorderFactory;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;

import br.nom.camargo.wanderson.hermes.RemoteServer;
import br.nom.camargo.wanderson.hermes.RemoteServer.RemoteStatus;
import br.nom.camargo.wanderson.hermes.adapter.BluetoothAdapter;
import br.nom.camargo.wanderson.hermes.adapter.EthernetAdapter;
import br.nom.camargo.wanderson.presenter.PresenterRemote.PresenterCommand;

public class PresenterView extends JFrame implements Observer
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -3018980289724185784L;
    private JStatusBar status;
    private JTable table;
    private JMenuItem mbluetooth;
    private JMenuItem methernet;
    private JMenuItem mstop;

    private RemoteServer server;
    private PresenterRemote remote;

    /**
     * Construtor
     */
    public PresenterView()
    {
        super(); init();

        server = new RemoteServer();
        remote = new PresenterRemote();
        server.setControl(remote);

        server.addObserver(this);
        remote.addObserver(this);

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

        /* Topo */
        JPanel banner = new JPanel();
        banner.setBackground(Color.WHITE);
        banner.setPreferredSize(new Dimension(0, 100));
        JLabel blabel = new JLabel("Commands");
        banner.setLayout(new BorderLayout());
        banner.add(blabel, BorderLayout.WEST);
        add(banner, BorderLayout.NORTH);

        /* Status */
        status = new JStatusBar();
        add(status, BorderLayout.PAGE_END);

        /* Tabela de Comandos */
        table = new JTable();
        JScrollPane scroll = new JScrollPane(table);
        DefaultTableModel model = new DefaultTableModel();
        model.addColumn("Name");
        model.addColumn("Status");
        model.addRow(new Object[]{"Left","Released"});
        model.addRow(new Object[]{"Right","Released"});
        table.setModel(model);
        table.setEnabled(false);
        add(scroll, BorderLayout.CENTER);

        /* Menu Servidor */
        mbluetooth = new JMenuItem("Start Bluetooth");
        mbluetooth.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                BluetoothAdapter adapter = new BluetoothAdapter();
                server.setAdapter(adapter);
                new Thread(server).start();
            }
        });
        methernet = new JMenuItem("Start Ethernet");
        methernet.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                EthernetAdapter adapter = new EthernetAdapter();
                server.setAdapter(adapter);
                new Thread(server).start();
            }
        });
        mstop = new JMenuItem("Stop");
        mstop.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                server.disconnect();
            }
        });
        JMenuItem mquit = new JMenuItem("Quit");
        mquit.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                setVisible(false);
                dispose();
            }
        });
        JMenu mserver = new JMenu("Server");
        mserver.add(mbluetooth);
        mserver.add(methernet);
        mserver.add(mstop);
        mserver.add(mquit);

        /* Menu Barra */
        JMenuBar menubar = new JMenuBar();
        menubar.add(mserver);
        setJMenuBar(menubar);

        return this;
    }

    public PresenterView setStatusMessage(String message)
    {
        status.setMessage(message);
        return this;
    }

    public void update(Observable o, Object arg)
    {
        if (o instanceof RemoteServer) {
            RemoteStatus status = ((RemoteServer) o).getStatus();
            switch (status) {
            case DISCONNECTED:
                setStatusMessage("Disconnected");
                break;
            case CONNECTING:
                setStatusMessage("Connecting...");
                break;
            case CONNECTED:
                setStatusMessage("Connected!");
                break;
            case DISCONNECTING:
                setStatusMessage("Disconnecting...");
                break;
            }
        }
    }

    public static void main(String args[])
    {
        PresenterView view = new PresenterView();
        view.setDefaultCloseOperation(EXIT_ON_CLOSE);
        view.setVisible(true);
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
