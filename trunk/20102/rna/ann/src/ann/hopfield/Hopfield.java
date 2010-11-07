package ann.hopfield;

import ann.matrix.*;

/**
 * Hopfield Network
 * Rede Neural Artificial
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class Hopfield
{
    /**
     * Pesos da Rede
     */
    private Matrix weights;

    /**
     * Construtor Padrão
     * @param size Número de Neurônios
     */
    public Hopfield(int size)
    {
        this.weights = new Matrix(size, size);
    }

    /**
     * Informa a Matriz de Pesos Utilizada
     * @return Matriz de Pesos
     */
    public Matrix getMatrix()
    {
        return this.weights;
    }

    /**
     * Informa o Número de Neurônios Utilizados
     * @return Total de Neurônios
     */
    public int getNeuronCount()
    {
        return this.getMatrix().getRows();
    }

    /**
     * Treina a Rede Conforme Padrão Informado
     * @param pattern Padrão de Treinamento
     * @return Próprio Objeto para Encadeamento
     */
    public Hopfield train(double pattern[])
    {
        if (this.getNeuronCount() != pattern.length) {
            throw new HopfieldException("Invalid Pattern Length");
        }

        Matrix m2 = Matrix.createRowMatrix(pattern);
        Matrix m1 = m2.transpose();
        Matrix m3 = m1.multiply(m2);

        Matrix identity = Matrix.createIdentityMatrix(pattern.length);
        Matrix m4 = m3.subtract(identity);

        this.weights = this.getMatrix().add(m4);

        return this;
    }

    /**
     * Apresenta um Padrão para a Rede
     * @param pattern Padrão Apresentado
     * @return Padrão Adquirido da Rede
     */
    public double[] present(double pattern[])
    {
        double output[] = new double[pattern.length];
        Matrix input = Matrix.createRowMatrix(pattern);

        Matrix column;
        double product;
        for (int i = 0; i < pattern.length; i++) {
            column = this.getMatrix().getCol(i).transpose();
            product = input.dotProduct(column);
            if (product > 0) {
                output[i] = 1;
            } else {
                output[i] = -1;
            }
        }
        return output;
    }
}
