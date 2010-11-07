package ann.matrix;

import java.io.*;
import java.text.*;

/**
 * Matriz
 * 
 * Cria métodos para cálculo de pesos das redes neurais artificiais através de
 * manipulação entre matrizes. Métodos estáticos trabalham como fábricas de
 * matrizes utilizando estruturas vetoriais de números com ponto flutuante.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class Matrix implements Cloneable, Serializable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 758964985243133468L;

    /**
     * Valores Internos da Matriz
     */
    private double values[][];

    /**
     * Construtor Padrão
     * @param rows Número de Linhas
     * @param cols Número de Colunas
     */
    public Matrix(int rows, int cols)
    {
        this.values = new double[rows][cols];
    }

    /**
     * Construtor com Matriz de Tipos Primitivos
     * @param source Valores para Inserir na Matriz
     */
    public Matrix(double source[][])
    {
        this(source.length, source[0].length);
        int rows = this.getRows();
        int cols = this.getCols();
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                this.set(i, j, source[i][j]);
            }
        }
    }

    /**
     * Fabricação de Matriz de Coluna Única
     * @param input Vetor da Coluna para Matriz
     * @return Nova Matriz Configurada
     */
    public static Matrix createColumnMatrix(double input[])
    {
        double values[][] = new double[input.length][1];
        for (int row = 0; row < input.length; row++) {
            values[row][0] = input[row];
        }
        return new Matrix(values);
    }

    /**
     * Fabricação de Matriz de Linha Única
     * @param input Vetor da Linha para Matriz
     * @return Nova Matriz Configurada
     */
    public static Matrix createRowMatrix(double input[])
    {
        double values[][] = new double[1][input.length];
        for (int col = 0; col < input.length; col++) {
            values[0][col] = input[col];
        }
        return new Matrix(values);
    }

    /**
     * Fabricação de Matriz Identidade
     * @param size Tamanho da Matriz Quadrada
     * @return Nova Matriz Configurada
     */
    public static Matrix createIdentityMatrix(int size)
    {
        Matrix result = new Matrix(size, size);
        for (int i = 0; i < size; i++) {
            result.set(i, i, 1);
        }
        return result;
    }

    /**
     * Adição de Valor à Posição Informada
     * @param row Número da Linha
     * @param col Número da Coluna
     * @param value Valor a Ser Adicionado ao Valor da Posição
     * @return Próprio Objeto para Encadeamento
     */
    public Matrix add(int row, int col, double value)
    {
        double result = this.get(row, col) + value;
        this.set(row, col, result);
        return this;
    }

    /**
     * Limpa a Matriz
     * Salva em Todas as Posições o Valor Nulo
     * @return Próprio Objeto para Encadeamento
     */
    public Matrix clear()
    {
        int rows = this.getRows();
        int cols = this.getCols();
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                this.set(i, j, 0);
            }
        }
        return this;
    }

    /**
     * Clonagem do Objeto
     * @return Novo Objeto Resultante da Clonagem
     */
    public Matrix clone()
    {
        return new Matrix(this.values);
    }

    /**
     * Retorno do Valor da Posição Solicitada
     * @param row Número da Linha
     * @param col Número da Coluna
     * @return Valor Solicitado
     */
    public double get(int row, int col)
    {
        return this.values[row][col];
    }

    /**
     * Retorno da Coluna em Formato de Matriz
     * @param col Número da Coluna
     * @return Coluna em Formato de Matriz
     */
    public Matrix getCol(int col)
    {
        int rows = this.getRows();
        double result[][] = new double[rows][1];
        for (int i = 0; i < rows; i++) {
            result[i][0] = this.get(i, col);
        }
        return new Matrix(result);
    }

    /**
     * Informa o Número de Colunas
     * @return Número de Colunas Configuradas
     */
    public int getCols()
    {
        return this.values[0].length;
    }

    /**
     * Retorno da Linha em Formato de Matriz
     * @param row Número da Linha
     * @return Linha em Formato de Matriz
     */
    public Matrix getRow(int row)
    {
        int cols = this.getCols();
        double result[][] = new double[1][cols];
        for (int i = 0; i < cols; i++) {
            result[0][i] = this.get(row, i);
        }
        return new Matrix(result);
    }

    /**
     * Informa o Número de Linhas
     * @return Número de Linhas Configuradas
     */
    public int getRows()
    {
        return this.values.length;
    }

    /**
     * Informa se a Matriz Possui Coluna ou Linha Única
     * @return Confirmação de Vetor
     */
    public boolean isVector()
    {
        return this.getCols() == 1 || this.getRows() == 1;
    }

    /**
     * Informa se a Matriz Possui Somente Valores Nulos
     * @return Confirmação de Valores Nulos
     */
    public boolean isZero()
    {
        int rows = this.getRows();
        int cols = this.getCols();
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                if (this.get(i, j) != 0) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Configura um Valor na Posição Determinada
     * @param row Número da Linha
     * @param col Número da Coluna
     * @param value Valor para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public Matrix set(int row, int col, double value)
    {
        this.values[row][col] = value;
        return this;
    }

    /**
     * Informa a Quantidade de Valores da Matriz
     * @return Tamanho da Matriz
     */
    public int size()
    {
        int rows = this.getRows();
        int cols = this.getCols();
        return rows * cols;
    }

    /**
     * Efetua o Somatório de Todos os Valores da Matriz
     * @return Resultado da Soma
     */
    public double sum()
    {
        double result = 0;
        int rows = this.getRows();
        int cols = this.getCols();
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                result = result + this.get(i, j);
            }
        }
        return result;
    }

    /**
     * Empacota Todos os Valores da Matriz em um Vetor de Tipos Primitivos
     * @return Valores Empacotados
     */
    public double[] toPackedArray()
    {
        int size = this.size();
        double result[] = new double[size];

        int index = 0;
        int rows  = this.getRows();
        int cols  = this.getCols();
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                result[index++] = this.get(i, j);
            }
        }

        return result;
    }

    /**
     * Soma de Matrizes e Retorna uma Nova Matriz Resultante
     * @param matrix Matriz para Soma
     * @return Nova Matriz Resultante da Adição
     */
    public Matrix add(Matrix matrix)
    {
        if (this.getRows() != matrix.getRows()) {
            throw new MatrixException("Invalid Row Count");
        }
        if (this.getCols() != matrix.getCols()) {
            throw new MatrixException("Invalid Column Count");
        }

        int rows = this.getRows();
        int cols = this.getCols();

        double result[][] = new double[rows][cols];
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                result[i][j] = this.get(i, j) + matrix.get(i, j);
            }
        }

        return new Matrix(result);
    }

    /**
     * Divisão de Matriz por Escalar
     * @param value Valor Escalar para Divisão
     * @return Nova Matriz Resultante da Divisão Escalar
     */
    public Matrix divide(double value)
    {
        int rows = this.getRows();
        int cols = this.getCols();
        double result[][] = new double[rows][cols];
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                result[i][j] = this.get(i, j) / value;
            }
        }
        return new Matrix(result);
    }

    /**
     * Produto Escalar de Dois Vetores
     * @param matrix Vetor para Cálculo do Produto
     * @return Resultado do Cálculo
     */
    public double dotProduct(Matrix matrix)
    {
        if (!(this.isVector() && this.isVector())) {
            throw new MatrixException("Both Matrices Must Be Vectors");
        }
        if (this.size() != matrix.size()) {
            throw new MatrixException("Both Matrices Must Have Same Size");
        }

        double a[] = this.toPackedArray();
        double b[] = matrix.toPackedArray();
        double result = 0;
        double length = this.size();
        for (int i = 0; i < length; i++) {
            result = result + a[i] * b[i];
        }

        return result;
    }

    /**
     * Múltiplicação de Matriz por Escalar
     * @param value Valor Escalar para Multiplicação
     * @return Nova Matriz Resultante da Multiplicação
     */
    public Matrix multiply(double value)
    {
        int rows = this.getRows();
        int cols = this.getCols();
        double result[][] = new double[rows][cols];
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                result[i][j] = this.get(i, j) * value;
            }
        }
        return new Matrix(result);
    }

    /**
     * Multiplicação de Matriz por Matriz
     * @param matrix Matriz para Multiplicação
     * @return Nova Matriz Resultante da Multiplicação
     */
    public Matrix multiply(Matrix matrix)
    {
        if (this.getCols() != matrix.getRows()) {
            throw new MatrixException("Invalid Row Count");
        }

        int rows = this.getRows();
        int cols = matrix.getCols();
        double result[][] = new double[rows][cols];

        double value;
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                value = 0;
                for (int k = 0; k < this.getCols(); k++) {
                    value = value + this.get(i, k) * matrix.get(k, j);
                }
                result[i][j] = value;
            }
        }

        return new Matrix(result);
    }

    /**
     * Diferença de Duas Matrizes
     * @param matrix Matriz para Cálculo de Subtração
     * @return Matriz Resultante da Subtração
     */
    public Matrix subtract(Matrix matrix)
    {
        if (this.getRows() != matrix.getRows()) {
            throw new MatrixException("Invalid Row Count");
        }
        if (this.getCols() != matrix.getCols()) {
            throw new MatrixException("Invalid Column Count");
        }

        int rows = this.getRows();
        int cols = this.getCols();
        double result[][] = new double[rows][cols];
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                result[i][j] = this.get(i, j) - matrix.get(i, j);
            }
        }

        return new Matrix(result);
    }

    /**
     * Cálculo da Matriz Inversa
     * @return Nova Matriz Resultante da Inversa
     */
    public Matrix transpose()
    {
        int rows = this.getRows();
        int cols = this.getCols();
        double inverse[][] = new double[cols][rows];
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                inverse[j][i] = this.get(i, j);
            }
        }
        return new Matrix(inverse);
    }

    /**
     * Cálculo do Tamanho do Vetor Resultante
     * @return Valor do Tamanho do Vetor
     */
    public double vectorLength()
    {
        if (!this.isVector()) {
            throw new MatrixException("Matrix Must Be Vector");
        }
        double vector[] = this.toPackedArray();
        double result = 0;
        for (int i = 0; i < vector.length; i++) {
            result = result + Math.pow(vector[i], 2);
        }
        return Math.sqrt(result);
    }

    /**
     * Configura Valores PseudoAleatórios para a Matriz
     * @param min Valor Mínimo
     * @param max Valor Máximo
     * @return Próprio Objeto para Encadeamento
     */
    public Matrix randomize(double min, double max)
    {
        int rows = this.getRows();
        int cols = this.getCols();
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                this.set(i, j, Math.random() * (max - min) + min);
            }
        }
        return this;
    }

    /**
     * Informa Todos os Valores Configurados
     * @return Texto Representante dos Valores
     */
    public String toString()
    {
        int rows = this.getRows();
        int cols = this.getCols();
        DecimalFormat formatter = new DecimalFormat("0.0000000000000000");
        StringBuilder builder = new StringBuilder();
        builder.append("[");
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                builder.append("(" + i + "," + j + ",");
                builder.append(formatter.format(this.get(i, j)));
                builder.append(")");
                if (!(i + 1 == rows && j + 1 == cols)) {
                    builder.append(",");
                }
            }
        }
        return builder.toString();
    }
}