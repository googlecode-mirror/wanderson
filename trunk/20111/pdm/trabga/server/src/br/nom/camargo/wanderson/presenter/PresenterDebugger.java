package br.nom.camargo.wanderson.presenter;

import java.awt.Dimension;

import javax.swing.JFrame;
import javax.swing.JScrollPane;
import javax.swing.JTable;

public class PresenterDebugger extends JFrame
{
    private static final long serialVersionUID = 270521177924458868L;

    public PresenterDebugger()
    {
        super("Presenter Debugger");
        Dimension d = new Dimension(400, 300);
        setSize(d);
        setPreferredSize(d);
        setResizable(false);
        setDefaultCloseOperation(DISPOSE_ON_CLOSE);

        String columns[] = {"Element","Message"};
        String data[][] = {{"Debugger","Start"}};
        JTable table = new JTable(data, columns);
        JScrollPane scroll = new JScrollPane(table);
        add(scroll);
    }
}
