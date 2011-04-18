package br.nom.camargo.wanderson.presenter;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.logging.Handler;
import java.util.logging.LogRecord;
import java.util.logging.Logger;

import javax.swing.JFrame;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;

public class PresenterDebugger extends JFrame
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 270521177924458868L;

    /**
     * Modelo de Armazenamento da Tabela de Mensagens
     */
    private DefaultTableModel model;

    /**
     * Construtor
     */
    public PresenterDebugger()
    {
        super(); init();

        /* Anexo de Manipulador de Log */
        Logger l = Logger.getLogger("Hermes_RemoteLogger");
        l.addHandler(new Handler() {
            public void publish(LogRecord record) {
                addMessage(record);
            }
            public void flush() {}
            public void close() throws SecurityException {}
        });
    }

    /**
     * Inicialização de Componentes
     * @return Próprio Objeto para Encadeamento
     */
    public PresenterDebugger init()
    {
        /* Configurações */
        setTitle("Presenter Debugger");
        Dimension d = new Dimension(600,300);
        setSize(d);
        setPreferredSize(d);

        /* Tabela de Mensagens */
        model = new DefaultTableModel();
        model.addColumn("Level");
        model.addColumn("Element");
        model.addColumn("Message");
        JTable table = new JTable(model);
        JScrollPane scroll = new JScrollPane(table);
        add(scroll, BorderLayout.CENTER);
        table.getColumnModel().getColumn(0).setMaxWidth(60);
        table.getColumnModel().getColumn(0).setMinWidth(60);
        table.getColumnModel().getColumn(1).setMaxWidth(100);
        table.getColumnModel().getColumn(1).setMinWidth(100);
        table.setEnabled(false);

        /* Menu */
        JMenuItem mclear = new JMenuItem("Clear");
        mclear.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                clear();
            }
        });
        JMenu mdebugger = new JMenu("Debugger");
        mdebugger.add(mclear);

        /* Barra de Menu Principal */
        JMenuBar menubar = new JMenuBar();
        menubar.add(mdebugger);
        setJMenuBar(menubar);

        return this;
    }

    /**
     * Limpa a Tabela de Mensagens
     * @return Próprio Objeto para Encadeamento
     */
    public PresenterDebugger clear()
    {
        model.getDataVector().clear();
        model.fireTableRowsDeleted(0, 0);
        return this;
    }

    /**
     * Adiciona Mensagens na Tabela
     * @param message Valor para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public PresenterDebugger addMessage(LogRecord record)
    {
        String message = record.getMessage();
        int index = message.indexOf(' ');
        String level   = record.getLevel().toString();
        String element = message.substring(0, index);
        String content = message.substring(index +1);
        String data[] = {level, element, content};
        model.addRow(data);
        return this;
    }
}
