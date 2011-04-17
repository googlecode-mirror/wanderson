package br.nom.camargo.wanderson.presenter;

import java.awt.Dimension;
import java.awt.Point;
import java.util.logging.Handler;
import java.util.logging.LogRecord;
import java.util.logging.Logger;

import javax.swing.JFrame;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JViewport;
import javax.swing.table.DefaultTableModel;

public class PresenterDebugger extends JFrame
{
    private static final long serialVersionUID = 270521177924458868L;
    private JTable table;

    public PresenterDebugger()
    {
        super("Presenter Debugger");
        Dimension d = new Dimension(600, 300);
        setSize(d);
        setPreferredSize(d);
        setResizable(false);
        setDefaultCloseOperation(DISPOSE_ON_CLOSE);

        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        l.addHandler(new Handler() {
            public void publish(LogRecord record) {
                debug(record);
            }
            public void flush() {}
            public void close() throws SecurityException {}
        });

        String columns[] = {"Element","Message"};
        DefaultTableModel model = new DefaultTableModel();
        for (String column : columns) {
            model.addColumn(column);
        }
        table = new JTable(model);
        table.getColumnModel().getColumn(0).setMaxWidth(100);
        JScrollPane scroll = new JScrollPane(table);
        scroll.setVerticalScrollBarPolicy(
            JScrollPane.VERTICAL_SCROLLBAR_ALWAYS);
        scroll.setHorizontalScrollBarPolicy(
            JScrollPane.HORIZONTAL_SCROLLBAR_NEVER);
        add(scroll);
    }

    public PresenterDebugger debug(LogRecord record)
    {
        int index = record.getMessage().indexOf(' ');
        String element = record.getMessage().substring(0, index);
        String message = record.getMessage().substring(index +1);
        ((DefaultTableModel) table.getModel())
            .addRow(new Object[]{element,message});
        JViewport sp = (JViewport) table.getParent();
        sp.setViewPosition(new Point(0,table.getHeight()));
        return this;
    }
}
