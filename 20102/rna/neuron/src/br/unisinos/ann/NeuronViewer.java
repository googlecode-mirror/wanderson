package br.unisinos.ann;

import java.awt.*;
import javax.swing.*;
import java.awt.event.*;
import javax.swing.event.*;

/**
 * Interface de Visualização do Neurônio
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class NeuronViewer extends JFrame implements Runnable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 740061407769307204L;

    /**
     * Neurônio Atual
     */
    private Neuron neuron;

    /**
     * Mensagem da Barra de Status
     */
    private JLabel message;

    /**
     * Caixa de Valores de Entrada
     */
    private JTextArea inputs;

    /**
     * Caixa de Escolha do Comando para Execução
     */
    private JComboBox function;

    /**
     * Caixa para Exibição do Valor de Saída do Neurônio
     */
    private JTextField output;

    /**
     * Caixa de Exibição dos Pesos Configurados
     */
    private JTextArea weights;

    /**
     * Tamanho de Entradas para o Neurônio
     */
    private JTextField size;

    /**
     * Construtor da Classe e da Interface de Visualização
     */
    public NeuronViewer()
    {
        super("Neuron Viewer");
        this.setSize(640, 480);
        this.setResizable(false);
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        inputs = new JTextArea();
        function = new JComboBox();
        function.addItem(NeuronFunction.THRESHOLD);
        function.addItem(NeuronFunction.SIGMOID);
        function.addItem(NeuronFunction.HYPERBOLIC);
        output = new JTextField();
        weights = new JTextArea();
        size = new JTextField();
        size.setText("3");

        JPanel top = new JPanel();
        top.setBackground(Color.WHITE);
        top.add(new JLabel("Artificial Neuron"));
        this.add(top, BorderLayout.PAGE_START);

        JPanel status = new JPanel();
        status.setBorder(BorderFactory.createLoweredBevelBorder());
        status.setLayout(new BoxLayout(status, BoxLayout.X_AXIS));
        status.setPreferredSize(new Dimension(0, 25));
        message = new JLabel();
        status.add(message);
        this.add(status, BorderLayout.PAGE_END);

        JPanel middle = new JPanel();
        middle.setLayout(new GridLayout(1,2));
        this.add(middle, BorderLayout.CENTER);

        JPanel left = new JPanel(new FlowLayout(FlowLayout.LEADING));
        left.setBorder(BorderFactory.createEtchedBorder());
        left.setLayout(null);
        JLabel inputLabel = new JLabel("Inputs");
        inputLabel.setLabelFor(inputs);
        inputLabel.setBounds(10, 0, 295, 20);
        left.add(inputLabel);
        inputs.setBorder(BorderFactory.createLineBorder(Color.GRAY));
        inputs.setBounds(10, 21, 295, 370);
        left.add(inputs);
        middle.add(left);

        JPanel right = new JPanel();
        right.setBorder(BorderFactory.createEtchedBorder());
        right.setLayout(null);
        JLabel functionLabel = new JLabel("Function");
        functionLabel.setLabelFor(function);
        functionLabel.setBounds(10, 0, 295, 20);
        right.add(functionLabel);
        function.setBounds(10, 21, 295, 25);
        function.setBackground(Color.WHITE);
        right.add(function);
        JLabel outputLabel = new JLabel("Output");
        outputLabel.setLabelFor(output);
        outputLabel.setBounds(10, 46, 295, 20);
        right.add(outputLabel);
        output.setBounds(10, 66, 295, 25);
        right.add(output);
        JLabel weightLabel = new JLabel("Weights");
        weightLabel.setLabelFor(weights);
        weightLabel.setBounds(10, 91, 295, 20);
        right.add(weightLabel);
        weights.setBounds(10, 111, 295, 225);
        weights.setBorder(BorderFactory.createLineBorder(Color.GRAY));
        right.add(weights);
        JButton activate = new JButton("Activate");
        activate.addMouseListener(new ActivateListener());
        activate.setBounds(205, 360, 100, 30);
        right.add(activate);
        JButton reset = new JButton("Reset");
        reset.addMouseListener(new ResetListener());
        reset.setBounds(100, 360, 100, 30);
        right.add(reset);
        JLabel sizeLabel = new JLabel("Input Size");
        sizeLabel.setLabelFor(size);
        sizeLabel.setBounds(10, 340, 85, 20);
        right.add(sizeLabel);
        size.setBounds(10, 360, 85, 31);
        right.add(size);
        middle.add(right);

        this.reset();
    }

    /**
     * Fluxo de Execução Principal
     */
    public void run()
    {
        this.setVisible(true);
    }

    /**
     * Ativação do Neurônio
     * @return Próprio Objeto
     */
    public NeuronViewer activate()
    {
        output.setText("");
        String values[] = inputs.getText().split("\n");
        double inputs[];
        inputs = new double[values.length];
        int i = 0;
        try {
            for (i = 0; i < inputs.length; i++) {
                inputs[i] = Double.parseDouble(values[i]);
            }
        } catch (NumberFormatException e) {
            message.setText("Invalid Number. Input Line: " + i);
            return this;
        }
        double result = 0;
        try {
            NeuronFunction f = (NeuronFunction) function.getSelectedItem();
            result = neuron.activate(f, inputs);
        } catch (AnnException e) {
            message.setText(e.getMessage());
            return this;
        }
        output.setText("" + result);
        this.updateWeightViewer();
        message.setText("Done");
        return this;
    }

    private NeuronViewer updateWeightViewer()
    {
        double w[] = neuron.getWeights();
        weights.setText("");
        for (int i = 0; i < w.length; i++) {
            weights.setText(weights.getText() + i + ": " + w[i] + "\n");
        }
        return this;
    }

    /**
     * Reconfiguração do Neurônio Conforme Dados de Caixa Específica
     * @return Próprio Objeto
     */
    public NeuronViewer reset()
    {
        output.setText("");
        inputs.setText("");
        try {
            int numberOfInputs = Integer.parseInt(size.getText());
            neuron = new Neuron(numberOfInputs);
        } catch (NumberFormatException e) {
            message.setText(e.getMessage());
            return this;
        }
        this.updateWeightViewer();
        message.setText("Ready");
        return this;
    }

    /**
     * Classe Aninhada para Botão de Ativação
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    class ActivateListener extends MouseInputAdapter
    {
        public void mouseClicked(MouseEvent e)
        {
            activate();
        }
    }

    /**
     * Classe Aninhada para Botão de Reinicialização
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    class ResetListener extends MouseInputAdapter
    {
        public void mouseClicked(MouseEvent e)
        {
            reset();
        }
    }

    /**
     * Método Principal de Execução
     * @param args Argumentos de Entrada
     */
    public static void main(String args[])
    {
        NeuronViewer viewer = new NeuronViewer();
        viewer.run();
    }
}
