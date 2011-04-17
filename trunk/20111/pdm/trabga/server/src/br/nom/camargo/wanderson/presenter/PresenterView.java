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

public class PresenterView extends JFrame implements Observer, Runnable
{
    private static final long serialVersionUID = 866195409376067052L;
    private JLabel status;
    private PresenterDebugger debugger;
    private Presenter presenter;

    public PresenterView init()
    {
        Dimension d = new Dimension(300, 400);
        setSize(d);
        setPreferredSize(d);
        setDefaultCloseOperation(EXIT_ON_CLOSE);
        setResizable(false);

        presenter = new Presenter();
        debugger  = new PresenterDebugger();

        JPanel top = new JPanel();
        top.setBackground(Color.WHITE);
        top.setPreferredSize(new Dimension(300,100));
        top.setBorder(BorderFactory.createRaisedBevelBorder());
        add(top, BorderLayout.NORTH);

        JPanel bottom = new JPanel();
        status = new JLabel();
        bottom.add(status);
        bottom.setBorder(BorderFactory.createLoweredBevelBorder());
        add(bottom, BorderLayout.SOUTH);

        String columns[] = {"Name","Status"};
        String data[][] = {{"Left","Released"},{"Right","Released"}};
        JTable table = new JTable(data, columns);
        JScrollPane scroll = new JScrollPane(table);
        add(scroll);

        JMenu mserver = new JMenu("Server");
        mserver.setMnemonic('S');
        JMenuItem methernet = new JMenuItem("Start Ethernet");
        methernet.setMnemonic('E');
        methernet.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                presenter.ethernet();
                new Thread(presenter).start();
            }
        });
        mserver.add(methernet);
        JMenuItem mbluetooth = new JMenuItem("Start Bluetooth");
        mbluetooth.setMnemonic('B');
        mbluetooth.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                presenter.bluetooth();
                new Thread(presenter).start();
            }
        });
        mserver.add(mbluetooth);
        JMenuItem mstop = new JMenuItem("Stop");
        mstop.setMnemonic('S');
        mstop.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                presenter.disconnect();
            }
        });
        mserver.add(mstop);
        JMenuItem mdebugger = new JMenuItem("Debugger");
        mdebugger.setMnemonic('D');
        mdebugger.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                debugger.setVisible(true);
            }
        });
        mserver.add(mdebugger);
        JMenuItem mclose = new JMenuItem("Close");
        mclose.setMnemonic('C');
        mclose.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                setVisible(false);
                dispose();
                System.exit(0);
            }
        });
        mserver.add(mclose);

        JMenu mhelp = new JMenu("Help");
        mhelp.setMnemonic('H');
        JMenuItem mabout = new JMenuItem("About");
        mabout.setMnemonic('A');
        mhelp.add(mabout);

        JMenuBar bar = new JMenuBar();
        bar.add(mserver);
        bar.add(mhelp);
        setJMenuBar(bar);

        setStatus("Closed");

        return this;
    }

    public PresenterView()
    {
        super("Presenter");
    }

    public PresenterView setStatus(String message)
    {
        status.setText(message);
        return this;
    }

    public void update(Observable o, Object arg)
    {
        if (o instanceof PresenterRemote) {
            System.out.println("Ação!");
        }
    }

    public void run()
    {
        setVisible(true);
    }

    public static void main(String args[])
    {
        PresenterView main = new PresenterView();
        main.run();
    }

}
