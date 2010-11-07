package ann.feedforward.backpropagation;

import ann.feedforward.*;
import java.util.*;

/**
 * Treinamento de Back Propagation para Redes Feed Forward
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class BackPropagation
{
    /**
     * Mapeador de Camadas da Rede e de Treinamento
     */
    private HashMap<FeedForwardLayer, BackPropagationLayer> mapper;

    /**
     * Rede para Execução do Treinamento
     */
    private FeedForwardNetwork network;

    /**
     * Fator de Treinamento
     */
    private double learn;

    /**
     * Fator Momentâneo
     */
    private double momentum;

    /**
     * Erro Atual da Rede
     */
    private double error;

    /**
     * Entradas para Treinamento
     */
    private double input[][];

    /**
     * Saídas Ideais para as Entradas do Treinamento
     */
    private double ideal[][];

    /**
     * Construtor Padrão
     * @param network Rede para Treinamento
     * @param input Valores de Entrada
     * @param ideal Valores Ideais para Saída Conforme Entrada
     * @param learn Taxa de Treinamento
     * @param momentum Valor Momentâneo
     */
    public BackPropagation(FeedForwardNetwork network, double input[][],
        double ideal[][], double learn, double momentum)
    {
        this.network = network;
        this.input   = input;
        this.ideal   = ideal;
        this.setLearn(learn).setMomentum(momentum);

        this.mapper = new HashMap<FeedForwardLayer, BackPropagationLayer>();

        BackPropagationLayer bp;
        for (FeedForwardLayer layer : network.getLayers()) {
            bp = new BackPropagationLayer(this, layer);
            this.mapper.put(layer, bp);
        }
    }

    /**
     * Informa a Rede em Treinamento
     * @return Rede Configurada para Treino
     */
    public FeedForwardNetwork getNetwork()
    {
        return this.network;
    }

    /**
     * Configura a Taxa de Treinamento
     * @param learn Fator de Treinamento
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagation setLearn(double learn)
    {
        this.learn = learn;
        return this;
    }

    /**
     * Configura o Valor Momentâneo
     * @param momentum Fator Momentâneo
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagation setMomentum(double momentum)
    {
        this.momentum = momentum;
        return this;
    }

    /**
     * Informa o Valor da taxa de Treinamento
     * @return Valor Configurado para o Treino
     */
    public double getLearn()
    {
        return this.learn;
    }

    /**
     * Informa o Valor da Taxa Momentânea
     * @return Valor Configurado para o Momento da Rede
     */
    public double getMomentum()
    {
        return this.momentum;
    }

    /**
     * Taxa Atual de Erro da Rede
     * @return Valor Informado pelo Back Propagation
     */
    public double getError()
    {
        return this.error;
    }

    /**
     * Informa a Camada de Back Propagation para a Camada da Rede
     * @param layer Camada da Rede para Entrada do Mapeamento
     * @return Saída de Camada Back Propagation Conforme Mapeamento
     */
    public BackPropagationLayer getBackPropagationLayer(FeedForwardLayer layer)
    {
        BackPropagationLayer bp = this.mapper.get(layer);
        if (bp == null) {
            throw new BackPropagationException("Invalid Layer");
        }
        return bp;
    }

    /**
     * Cálculo da Taxa de Erro Atual
     * @param ideal Valores Ideais para a Entrada Atual
     * @return Próprio Objeto para Encadeamento
     */
    private BackPropagation calcError(double ideal[])
    {
        FeedForwardNetwork network = this.getNetwork();
        if (ideal.length != network.getOutputLayer().getNeuronCount()) {
            throw new BackPropagationException("Invalid Ideal Size");
        }

        for (FeedForwardLayer layer : network.getLayers()) {
            this.getBackPropagationLayer(layer).clearError();
        }

        FeedForwardLayer layer;
        Object[] set = network.getLayers().toArray();
        for (int i = set.length - 1; i >= 0; i--) {
            layer = (FeedForwardLayer) set[i];
            if (layer.isOutput()) {
                this.getBackPropagationLayer(layer).calcError(ideal);
            } else {
                this.getBackPropagationLayer(layer).calcError();
            }
        }

        return this;
    }

    /**
     * Execução do Aprendizado Back Propagation
     * @return Próprio Objeto para Encadeamento
     */
    private BackPropagation learn()
    {
        double learn = this.getLearn();
        double momentum = this.getMomentum();

        for (FeedForwardLayer layer : this.getNetwork().getLayers()) {
            this.getBackPropagationLayer(layer).learn(learn, momentum);
        }

        return this;
    }

    /**
     * Iteração dos Valores Configurados em Tempo de Construção
     * @return Próprio Objeto para Encadeamento
     */
    public BackPropagation iterate()
    {
        for (int i = 0; i < input.length; i++) {
            this.network.computeOutputs(input[i]);
            this.calcError(ideal[i]);
        }
        this.learn();
        this.error = this.getNetwork().calculateError(input, ideal);
        return this;
    }
}
