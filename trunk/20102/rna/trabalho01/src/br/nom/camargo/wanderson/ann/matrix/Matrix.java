package br.nom.camargo.wanderson.ann.matrix;

import java.io.*;
import java.text.DecimalFormat;

/**
 * Matrix Class
 * Classe para trabalho sobre os pesos do conhecimento da rede neural artificial
 * utilizando operações matemáticas diretamente sobre matrizes
 * @author Wanderson Henrique Camargo Rosa
 */
public class Matrix implements Serializable, Cloneable
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -6163273612643435346L;

    /**
     * Valores da Matriz
     */
    private double values[][];

    /**
     * Construtor Padrão
     * @param rows Número de Linhas
     * @param cols Número de Colunas
     * @throws MatrixException Tamanho Inválido de Linhas ou Colunas
     */
    public Matrix(int rows, int cols) throws MatrixException
    {
        if (!(rows > 0 && cols > 0)) {
            throw new MatrixException("Invalid Row or Column Length");
        }
        this.values = new double[rows][cols];
    }

    /**
     * Construtor da Classe Através de Pesos Configurados
     * @param source Pesos Previamente Configurador em Matriz Primitiva
     * @throws MatrixException Tamanho Inválido de Colunas
     */
    public Matrix(double source[][]) throws MatrixException
    {
        int rows = source.length;
        int cols = source[0].length;
        this.values = new double[rows][cols];
        for (int i = 0; i < rows; i++) {
            if (source[i].length != cols) {
                throw new MatrixException("Invalid Column Length");
            }
            for (int j = 0; j < cols; j++) {
                this.set(i, j, source[i][j]);
            }
        }
    }

    /**
     * Método Estático para Criação de Matriz com Coluna Única
     * @param input Valores de Entrada
     * @return Matriz com os Valores de Entrada
     */
    public static Matrix createColumnMatrix(double input[])
    {
        try {
            Matrix matrix = new Matrix(input.length, 1);
            for (int row = 0; row < input.length; row++) {
                matrix.set(row, 0, input[row]);
            }
            return matrix;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Método Estático para Criação de Matriz com Linha Única
     * @param input Valores de Entrada
     * @return Matriz com os Valores de Entrada
     */
    public static Matrix createRowMatrix(double input[])
    {
        try {
            Matrix matrix = new Matrix(1, input.length);
            for (int col = 0; col < input.length; col++) {
                matrix.set(0, col, input[col]);
            }
            return matrix;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Cria uma Matriz Identidade
     * @param size Tamanho da Matriz Quadrada
     * @return Matriz Identidade de Tamanho Informado
     * @throws MatrixException Tamanho Lateral Inválido
     */
    public static Matrix createIdentityMatrix(int size) throws MatrixException
    {
        if (size < 1) {
            throw new MatrixException("Invalid Size");
        }
        try {
            Matrix matrix = new Matrix(size, size);
            for (int i = 0; i < size; i++) {
                for (int j = 0; j < size; i++) {
                    if (i == j) {
                        matrix.set(i, j, 1);
                    } else {
                        matrix.set(i, j, 0);
                    }
                }
            }
            return matrix;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Verificação de Posição Existente
     * @param row Número da Linha
     * @param col Número da Coluna
     * @return Confirmação da Existência da Posição
     */
    public boolean exists(int row, int col)
    {
        int maxRow = this.getRowCount() - 1;
        int maxCol = this.getColCount() - 1;
        return (row >= 0 && row <= maxRow && col >= 0 && col <= maxCol);
    }

    /**
     * Configuração de Valores da Matriz
     * @param row Número de Linha
     * @param col Número da Coluna
     * @param value Valor para Configuração
     * @return Próprio Objeto para Encadeamento
     * @throws Acesso Inválido de Elementos
     */
    public Matrix set(int row, int col, double value) throws MatrixException
    {
        if (!this.exists(row, col)) {
            throw new MatrixException("Invalid Matrix Element");
        }
        this.values[row][col] = value;
        return this;
    }

    /**
     * Informação de Valores da Matriz
     * @param row Número da Linha
     * @param col Número da Coluna
     * @return Valor Configurado na Posição Solicitada
     * @throws Acesso Inválido de Elementos
     */
    public double get(int row, int col) throws MatrixException
    {
        if (!this.exists(row, col)) {
            throw new MatrixException("Invalid Matrix Element");
        }
        return this.values[row][col];
    }

    /**
     * Número de Linhas da Matriz
     * @return Número Atual de Linhas na Matriz
     */
    public int getRowCount()
    {
        return this.values.length;
    }

    /**
     * Número de Colunas da Matriz
     * @return Número Atual de Colunas na Matriz
     */
    public int getColCount()
    {
        return this.values[0].length;
    }

    /**
     * Adiciona um Valor Escalar à Posição Informada
     * @param row Número da Linha
     * @param col Número da Coluna
     * @param value Valor para Adição
     * @return Próprio Objeto para Encadeamento
     * @throws Erro Interno de Adição
     */
    public Matrix add(int row, int col, double value) throws MatrixException
    {
        double result = this.get(row, col) + value;
        this.set(row, col, result);
        return this;
    }

    /**
     * Limpa a Matriz com Valores Nulos
     * @return Próprio Objeto para Encadeamento
     */
    public Matrix clear()
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    this.set(i, j, 0);
                }
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return this;
    }

    /**
     * Clonagem de Objeto
     * @return Objeto Clonado em Ponteiro Diferente de Memória
     */
    public Matrix clone()
    {
        try {
            return new Matrix(this.values);
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Retorno de Coluna em Formato Matricial
     * @param col Número da Coluna
     * @return Coluna Solicitada como Objeto Matriz
     * @throws MatrixException Coluna Inválida
     */
    public Matrix getCol(int col) throws MatrixException
    {
        int rows = this.getRowCount();
        double result[] = new double[rows];
        for (int i = 0; i < rows; i++) {
            result[i] = this.get(i, col);
        }
        return Matrix.createColumnMatrix(result);
    }

    /**
     * Retorno de Linha em Formato Matricial
     * @param row Número da Linha
     * @return Linha Solicitada como Objeto Matriz
     * @throws MatrixException Linha Inválida
     */
    public Matrix getRow(int row) throws MatrixException
    {
        int cols = this.getColCount();
        double result[] = new double[cols];
        for (int i = 0; i < cols; i++) {
            result[i] = this.get(row, i);
        }
        return Matrix.createRowMatrix(result);
    }

    /**
     * Informação sobre Matriz com Característica Vetorial
     * @return Confirmação da Solicitação
     */
    public boolean isVector()
    {
        return this.getColCount() == 1 || this.getRowCount() == 1;
    }

    /**
     * Informação sobre Matriz com Valores Nulos
     * @return Confirmação da Solicitação
     */
    public boolean isZero()
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    if (this.get(i, j) != 0) {
                        return false;
                    }
                }
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return true;
    }

    /**
     * Informação sobre Quantidade de Elementos na Matriz
     * @return Número Contabilizado de Elementos
     */
    public int size()
    {
        return this.getRowCount() * this.getColCount();
    }

    /**
     * Somatório de Todos Elementos da Matriz
     * @return Resultado da Operação de Soma sobre os Elementos
     */
    public double sum()
    {
        double result = 0;
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    result = result + this.get(i, j);
                }
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return result;
    }

    /**
     * Retorno de Valores em Somente um Vetor
     * @return Valores Compactados em Vetor
     */
    public double[] toPackedArray()
    {
        int size = this.size();
        double result[] = new double[size];
        int index = 0;
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    result[index] = this.get(i, j);
                    index = index + 1;
                }
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return result;
    }

    /**
     * Somatório de Matrizes
     * @param matrix Matriz para Operação de Soma
     * @return Nova Matriz com o Resultado da Operação
     * @throws MatrixException Matrizes Não Possuem o Mesmo Tamanho
     */
    public Matrix add(Matrix matrix) throws MatrixException
    {
        if (this.getRowCount() != this.getRowCount()) {
            throw new MatrixException("Invalid Row Count");
        }
        if (this.getColCount() != this.getColCount()) {
            throw new MatrixException("Invalid Col Count");
        }
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            Matrix result = new Matrix(rows, cols);
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    result.set(i, j, this.get(i, j) + matrix.get(i, j));
                }
            }
            return result;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Subtração de Matrizes
     * @param matrix Matriz para Operação
     * @return Nova Matriz Resultado da Operação
     * @throws MatrixException Número de Linhas ou Colunas Inválidos
     */
    public Matrix subtract(Matrix matrix) throws MatrixException
    {
        if (this.getRowCount() != matrix.getRowCount()) {
            throw new MatrixException("Invalid Row Count");
        }
        if (this.getColCount() != matrix.getColCount()) {
            throw new MatrixException("Invalid Column Count");
        }
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            Matrix result = new Matrix(rows, cols);
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    result.set(i, j, this.get(i, j) - matrix.get(i, j));
                }
            }
            return result;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Divisão por Escalar
     * @param value Número para Divisão de Elementos da Matriz
     * @return Nova Matriz com o Resultado da Operação
     */
    public Matrix divide(double value)
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            Matrix result = new Matrix(rows, cols);
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    result.set(i, j, this.get(i, j) / value);
                }
            }
            return result;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Produto Escalar Vetoriais
     * @param matrix Matriz para Executar a Operação
     * @return Resultado da Solicitação
     * @throws MatrixException Matrizes Não São Vetoriais
     * @throws MatrixException Matrizes Não Possuem o Mesmo Tamanho
     */
    public double dotProduct(Matrix matrix) throws MatrixException
    {
        if (!(this.isVector() && matrix.isVector())) {
            throw new MatrixException("Both Must Be Vectors");
        }
        if (this.size() != matrix.size()) {
            throw new MatrixException("Both Must Have Same Size");
        }
        double a[] = this.toPackedArray();
        double b[] = matrix.toPackedArray();
        double result = 0;
        for (int i = 0; i < a.length; i++) {
            result = result + a[i] * b[i];
        }
        return result;
    }

    /**
     * Multiplicação por Valor Escalar
     * @param value Valor para Multiplicação da Matriz
     * @return Nova Matriz Resultante da Operação
     */
    public Matrix multiply(double value)
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            Matrix result = new Matrix(rows, cols);
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    result.set(i, j, this.get(i, j) * value);
                }
            }
            return result;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Multiplicação de Matrizes
     * @param matrix Matriz para Operação
     * @return Nova Matriz Resultante da Operação
     * @throws MatrixException
     */
    public Matrix multiply(Matrix matrix) throws MatrixException
    {
        if (this.getColCount() != matrix.getRowCount()) {
            throw new MatrixException("Invalid Matrix Row Count");
        }
        int rows = this.getRowCount();
        int cols = matrix.getColCount();
        Matrix result = new Matrix(rows, cols);
        double value;
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                value = 0;
                for (int k = 0; k < this.getColCount(); k++) {
                    value = value + this.get(i, k) * matrix.get(k, j);
                }
                result.set(i, j, value);
            }
        }
        return result;
    }

    /**
     * Matriz Inversa
     * @return Resultado da Operação
     */
    public Matrix transpose()
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            Matrix inverse = new Matrix(cols, rows);
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    inverse.set(j, i, this.get(i, j));
                }
            }
            return inverse;
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
            return null;
        }
    }

    /**
     * Preenchimento com Valores Pseudo Aleatórios
     * @param min Valor Mínimo
     * @param max Valor Máximo
     * @return Próprio Objeto para Encadeamento
     */
    public Matrix randomize(double min, double max)
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        try {
            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    this.set(i, j, (Math.random() * (max - min)) + min);
                }
            }
        } catch (MatrixException e) {
            // Never Reached
            e.printStackTrace(System.err);
            System.exit(0);
        }
        return this;
    }

    /**
     * Visualização do Conteúdo da Matriz
     * @return Conteúdo Formatado Matricial
     */
    public String toString()
    {
        int rows = this.getRowCount();
        int cols = this.getColCount();
        DecimalFormat formatter = new DecimalFormat("0.0000000000000000");
        StringBuilder builder = new StringBuilder();
        builder.append("[");
        try {
            for (int i = 0; i < rows; i++) {
                builder.append("[");
                for (int j = 0; j < cols; j++) {
                    builder.append(formatter.format(this.get(i, j)));
                    if (j + 1 != cols) {
                        builder.append(", ");
                    }
                }
                builder.append("]");
                if (i + 1 != rows) {
                    builder.append(", ");
                }
            }
        } catch (MatrixException e) {
            e.printStackTrace(System.err);
            System.exit(0);
        }
        builder.append("]");
        return builder.toString();
    }
}
