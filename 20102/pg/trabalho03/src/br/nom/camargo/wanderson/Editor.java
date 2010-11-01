package br.nom.camargo.wanderson;

import java.awt.*;
import java.util.*;
import javax.swing.*;
import java.awt.event.*;

/**
 * Janela de Edição
 * Aplicação do Algoritmo Bresenhan e Derivados
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class Editor extends JFrame implements Runnable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -3853437962877352668L;

    /**
     * Instância Única do Objeto
     * Padrão de Projeto Singleton
     */
    private static Editor instance;

    /**
     * Objeto de Desenho
     */
    protected Canvas canvas;

    /**
     * Lista de Pontos
     */
    protected ArrayDeque<Point> points;

    /**
     * Ações Disponíveis
     */
    protected Action action;

    /**
     * Exibição dos Pontos Armazenados
     */
    protected JTextArea pointers;

    /**
     * Caixa para Escolha de Elementos Geométricos
     */
    protected GeometricChooser chooser;

    /**
     * Caixa para Escolha de Cores
     */
    protected ColorChooser color;

    /**
     * Mensagem da Barra de Status
     */
    protected JLabel message;

    /**
     * Coordenadas Atuais do Mouse
     */
    protected JLabel coordinates;

    /**
     * Construtor Padrão
     * Padrão de Projeto Singleton
     */
    private Editor()
    {
        super("Bresenhan Editor");
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setSize(845, 532);

        this.canvas = new Canvas();
        this.canvas.addMouseListener(new MousePointer());
        this.add(this.canvas);

        this.pointers = new JTextArea();
        this.pointers.setBounds(10, 55, 180, 200);
        this.pointers.setEditable(false);
        this.pointers.setBorder(BorderFactory.createLineBorder(Color.GRAY));
        JLabel titlePointers = new JLabel("Pointers");
        titlePointers.setLabelFor(this.pointers);
        titlePointers.setBounds(10, 35, 180, 20);

        this.chooser = new GeometricChooser();
        this.chooser.setBounds(10, 285, 180, 20);
        JLabel titleChooser = new JLabel("Element");
        titleChooser.setLabelFor(this.chooser);
        titleChooser.setBounds(10, 265, 180, 20);

        this.color = new ColorChooser();
        this.color.setBounds(10, 335, 180, 20);
        JLabel titleColor = new JLabel("Color");
        titleColor.setLabelFor(this.color);
        titleColor.setBounds(10, 315, 180, 20);

        JButton reset = new JButton("Reset");
        reset.setBounds(10, 365, 85, 30);
        reset.addMouseListener(new ResetPointer());

        JButton apply = new JButton("Apply");
        apply.setBounds(105, 365, 85, 30);
        apply.addMouseListener(new ApplyPointer());

        JPanel left = new JPanel();
        left.setPreferredSize(new Dimension(200,0));
        left.setBorder(BorderFactory.createEtchedBorder());
        left.setLayout(null);
        JLabel titleLabel = new JLabel("Bresenhan");
        titleLabel.setLabelFor(left);
        titleLabel.setBounds(10, 10, 180, 20);
        Font font = new Font(Font.SANS_SERIF, Font.BOLD, 20);
        titleLabel.setFont(font);

        left.add(titleLabel);
        left.add(titlePointers);
        left.add(this.pointers);
        left.add(titleChooser);
        left.add(this.chooser);
        left.add(titleColor);
        left.add(this.color);
        left.add(reset);
        left.add(apply);

        this.message = new JLabel("Ready");
        JPanel status = new JPanel();
        status.setBorder(BorderFactory.createLoweredBevelBorder());
        status.setLayout(new BoxLayout(status, BoxLayout.X_AXIS));
        status.setPreferredSize(new Dimension(0, 25));
        status.add(this.message);

        this.coordinates = new JLabel("Coordinate");

        this.add(left, BorderLayout.WEST);
        this.add(status, BorderLayout.SOUTH);

        this.points = new ArrayDeque<Point>();

        Dimension screen = Toolkit.getDefaultToolkit().getScreenSize();
        int x = (screen.width - this.getWidth()) /2;
        int y = (screen.height - this.getHeight()) / 2;
        this.setLocation(x, y);
    }

    /**
     * Acesso ao Objeto Único de Memória
     * Padrão de Projeto Singleton
     * @return Objeto Singleton
     */
    public static Editor getInstance()
    {
        if (Editor.instance == null) {
            Editor.instance = new Editor();
        }
        return Editor.instance;
    }

    /**
     * Acesso ao Objeto de Desenho
     * @return Objeto de Encapsulamento de Desenho
     */
    public Canvas getCanvas()
    {
        return this.canvas;
    }

    /**
     * Configura a Mensagem na Barra de Status
     * @param message Nova Mensagem
     * @return Próprio Objeto para Encadeamento
     */
    public Editor setMessage(String message)
    {
        this.message.setText(message);
        return this;
    }

    /**
     * Exibe as Coordenadas na Barra de Status
     * @param p Ponto das Coordenadas Atuais
     * @return Próprio Objeto para Encadeamento
     */
    public Editor setCoordinate(Point p)
    {
        this.coordinates.setText(p.toString());
        return this;
    }

    /**
     * Adiciona Pontos para Plotagem
     * @param p Novo Ponto
     * @return Próprio Objeto para Encadeamento
     */
    public Editor addPoint(Point p)
    {
        this.points.addLast(p);
        this.pointers.append(p.toString() + "\n");
        this.setMessage("New Point: " + p.toString());
        return this;
    }

    /**
     * Limpa a Lista de Pontos de Plotagem
     * @return Próprio Objeto para Encadeamento
     */
    public Editor resetPointers()
    {
        this.points.clear();
        this.pointers.setText("");
        this.setMessage("Done Clear Points");
        return this;
    }

    /**
     * Aplica os Pontos da Lista no Ambiente de Desenho
     * @return Próprio Objeto para Encadeamento
     */
    public Editor applyPointers()
    {
        String message = "Points Plotted";
        Canvas canvas = this.getCanvas();
        Color color = (Color) this.color.getSelectedItem();
        canvas.setForeground(color);

        Point a,b;
        Geometric geometric = (Geometric) this.chooser.getSelectedItem();
        try {
            switch (geometric) {
            case POINT:
                for (Point p : this.points) {
                    canvas.put(p.x, p.y);
                }
                break;
            case LINE:
                while (!this.points.isEmpty()) {
                    if (this.points.size() != 1) {
                        a = this.points.pollFirst();
                        b = this.points.pollFirst();
                        canvas.line(a.x, a.y, b.x, b.y);
                    } else {
                        this.points.clear();
                    }
                }
                break;
            case POLYGON:
                int size = this.points.size();
                int x[] = new int[size];
                int y[] = new int[size];
                for (int i = 0; i < size; i++) {
                    Point p = this.points.pollFirst();
                    x[i] = p.x;
                    y[i] = p.y;
                }
                canvas.polygon(x, y);
                break;
            case RECTANGLE:
                while (!this.points.isEmpty()) {
                    if (this.points.size() != 1) {
                        a = this.points.pollFirst();
                        b = this.points.pollFirst();
                        canvas.rectangle(a.x, a.y, b.x - a.x, b.y - a.y);
                    } else {
                        this.points.clear();
                    }
                }
                break;
            case SQUARE:
                while (!this.points.isEmpty()) {
                    if (this.points.size() != 1) {
                        a = this.points.pollFirst();
                        b = this.points.pollFirst();
                        canvas.square(a.x, a.y, b.x - a.x);
                    } else {
                        this.points.clear();
                    }
                }
                break;
            case ELLIPSE:
                while (!this.points.isEmpty()) {
                    if (this.points.size() != 1) {
                        a = this.points.pollFirst();
                        b = this.points.pollFirst();
                        canvas.ellipse(a.x, a.y, b.x - a.x, b.y - a.y);
                    } else {
                        this.points.clear();
                    }
                }
                break;
            case CIRCLE:
                while (!this.points.isEmpty()) {
                    if (this.points.size() != 1) {
                        a = this.points.pollFirst();
                        b = this.points.pollFirst();
                        canvas.circle(a.x, a.y, b.x - a.x);
                    } else {
                        this.points.clear();
                    }
                }
                break;
            case FILL:
                while (!this.points.isEmpty()) {
                    a = this.points.pollFirst();
                    canvas.fill(a.x, a.y);
                }
            }
        } catch(EditorException e) {
            message = e.getMessage();
        }
        canvas.update();
        this.resetPointers();
        this.setMessage(message);
        return this;
    }

    /**
     * Método Principal de Execução do Aplicativo
     */
    public void run()
    {
        this.setVisible(true);
    }

    /**
     * Método de Execução do Ambiente
     * @param args Parâmetros de Entrada
     */
    public static void main(String args[])
    {
        Editor editor = Editor.getInstance();
        editor.run();
    }

    /**
     * Classe Aninhada para Captura de Pontos
     *
     * @author Wanderson Henrique Camargo Rosa
     */
    private class MousePointer extends MouseAdapter
    {
        /**
         * Adiciona Pontos ao Editor
         */
        public void mouseClicked(MouseEvent event)
        {
            Editor.getInstance().addPoint(event.getPoint());
        }

        /**
         * Captura o Ponto Atual do Mouse no Ambiente de Desenho
         */
        public void mouseMoved(MouseEvent event)
        {
            Editor.getInstance().setCoordinate(event.getPoint());
        }
    }

    /**
     * Classe Aninhada para Ação de Limpeza de Pontos
     *
     * @author Wanderson Henrique Camargo Rosa
     */
    private class ResetPointer extends MouseAdapter
    {
        /**
         * Limpa a Lista de Pontos
         */
        public void mouseClicked(MouseEvent event)
        {
            Editor.getInstance().resetPointers();
        }
    }

    /**
     * Classe Aninhada para Ação de Plotagem dos Pontos
     *
     * @author Wanderson Henrique Camargo Rosa
     */
    private class ApplyPointer extends MouseAdapter
    {
        public void mouseClicked(MouseEvent event)
        {
            Editor.getInstance().applyPointers();
        }
    }
}
