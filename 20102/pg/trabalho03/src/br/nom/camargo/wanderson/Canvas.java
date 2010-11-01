package br.nom.camargo.wanderson;

import java.awt.*;
import java.util.*;
import javax.swing.*;
import java.awt.image.*;

/**
 * Objeto de Desenho
 * Encapsulamento de Comandos para Desenho
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class Canvas extends JPanel
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = -6364552781715803909L;

    /**
     * Imagem para Desenho
     */
    protected BufferedImage image;

    /**
     * Construtor Padrão
     */
    public Canvas()
    {
        this.setSize(640, 480);
        this.setForeground(Color.WHITE);
        Dimension size = this.getSize();
        int width  = (int) size.getWidth();
        int height = (int) size.getHeight();
        this.image =
            new BufferedImage(width, height, BufferedImage.TYPE_INT_RGB);
    }

    /**
     * Informa a Imagem Utilizada para Desenho
     * @return Imagem Atual
     */
    protected BufferedImage getImage()
    {
        return this.image;
    }

    /**
     * Sobrescrita do Método de Desenho
     */
    public void paintComponent(Graphics g)
    {
        super.paintComponent(g);
        BufferedImage image = this.getImage();
        g.drawImage(image, 0, 0, this);
    }

    /**
     * Atualiza o Ambiente de Desenho
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas update()
    {
        this.repaint();
        return this;
    }

    /**
     * Coloca um Ponto no Ambiente de Desenho
     * @param x Abscissa do Ponto
     * @param y Ordenada do Ponto
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas put(int x, int y)
    {
        Color color = this.getForeground();
        BufferedImage image = this.getImage();
        int width = image.getWidth();
        int height = image.getHeight();
        if (x >= 0 && x < width && y >= 0 && y < height) {
            image.setRGB(x, y, color.getRGB());
        }
        return this;
    }

    /**
     * Desenha um Ponto no Ambiente de Desenho
     * @param x Abscissa do Ponto
     * @param y Ordenada do Ponto
     * @return Próprio Objeto para Encadeamentos
     */
    public Canvas point(int x, int y)
    {
        this.put(x, y);
        return this;
    }

    /**
     * Optimizated Bresenhan Algorithm
     * Desenha uma Linha no Ambiente de Desenho
     * @param x1 Abscissa do Ponto 1
     * @param y1 Ordenada do Ponto 1
     * @param x2 Abscissa do Ponto 2
     * @param y2 Ordenada do Ponto 2
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas line(int x1, int y1, int x2, int y2)
    {
        boolean steep = Math.abs(y2 -y1) > Math.abs(x2 -x1);
        if (steep) {
            int a1;
            a1 = x1; x1 = y1; y1 = a1;
            a1 = x2; x2 = y2; y2 = a1;
        }
        if (x1 > x2) {
            int a1;
            a1 = x1; x1 = x2; x2 = a1;
            a1 = y1; y1 = y2; y2 = a1;
        }
        int deltax = x2 -x1;
        int deltay = Math.abs(y2 -y1);
        int error  = deltax /2;
        int ystep;
        int y = y1;
        ystep = y1 < y2 ? 1 : -1;
        for (int x = x1; x <= x2; x++) {
            if (steep) {
                this.put(y, x);
            } else {
                this.put(x, y);
            }
            error = error - deltay;
            if (error < 0) {
                y = y + ystep;
                error = error + deltax;
            }
        }
        return this;
    }

    /**
     * Desenha um Polígono no Ambiente de Desenho
     * @param x Vetor de Posições Abscissas
     * @param y Vetor de Posições Ordenadas
     * @throws Número Inválido de Pontos
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas polygon(int x[], int y[])
    {
        if (x.length != y.length || x.length < 3) {
            throw new EditorException("Invalid Number of Points");
        }
        int length = x.length;
        for (int i = 0; i < length -1; i++) {
            this.line(x[i], y[i], x[i+1], y[i+1]);
        }
        this.line(x[length -1], y[length -1], x[0], y[0]);
        return this;
    }

    /**
     * Desenha um Retângulo no Ambiente de Desenho
     * @param x Abscissa do Ponto Superior Esquerdo
     * @param y Ordenada do Ponto Superior Esquerdo
     * @param width Tamanho Horizontal
     * @param height Tamanho Vertical
     * @throws Medida Horizontal ou Vertical Inválida
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas rectangle(int x, int y, int width, int height)
    {
        if (width <= 0 || height <= 0) {
            throw new EditorException("Invalid Metrics");
        }
        int vx[] = {x, x +width, x +width, x};
        int vy[] = {y, y, y +height, y +height};
        this.polygon(vx, vy);
        return this;
    }

    /**
     * Desenha um Quadrado no Ambiente de Desenho
     * @param x Abscissa do Ponto Superior Esquerdo
     * @param y Abscissa do Ponto Superior Esquerdo
     * @param size Tamanho do Lado
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas square(int x, int y, int size)
    {
        if (size < 1) {
            throw new EditorException("Invalid Size");
        }
        this.rectangle(x, y, size, size);
        return this;
    }

    /**
     * Desenha uma Elipse no Ambiente de Desenho
     * Fast Ellipse Bresenhan by John Kennedy
     * @param cx Abscissa do Ponto Central
     * @param cy Ordenada do Ponto Central
     * @param rx Abscissa do Raio
     * @param ry Ordenada do Raio
     * @throws Tamanho do Raio Inválido
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas ellipse(int cx, int cy, int rx, int ry)
    {
        if (rx <= 0 || ry <= 0) {
            throw new EditorException("Invalid Radius Size");
        }

        int x, y;
        int xchange, ychange;
        int error;
        int twoAsquare, twoBsquare;
        int stoppingx, stoppingy;

        twoAsquare = 2 * rx * rx;
        twoBsquare = 2 * ry * ry;
        x = rx;
        y = 0;
        xchange = ry * ry * (1 - 2 * rx);
        ychange = rx * rx;
        error = 0;
        stoppingx = twoBsquare * rx;
        stoppingy = 0;

        while (stoppingx >= stoppingy) {
            this.ellipsePoints(cx, cy, x, y);
            y = y + 1;
            stoppingy = stoppingy + twoAsquare;
            error = error + ychange;
            ychange = ychange + twoAsquare;
            if ((2 * error + xchange) > 0) {
                x = x - 1;
                stoppingx = stoppingx - twoBsquare;
                error = error + xchange;
                xchange = xchange + twoBsquare;
            }
        }

        x = 0;
        y = ry;
        xchange = ry * ry;
        ychange = rx * rx * (1 -2 * ry);
        error = 0;
        stoppingx = 0;
        stoppingy = twoAsquare * ry;

        while (stoppingx <= stoppingy) {
            this.ellipsePoints(cx, cy, x, y);
            x = x + 1;
            stoppingx = stoppingx + twoBsquare;
            error = error + xchange;
            xchange = xchange + twoBsquare;
            if ((2 * error + ychange) > 0) {
                y = y - 1;
                stoppingy = stoppingy - twoAsquare;
                error = error + ychange;
                ychange = ychange + twoAsquare;
            }
        }

        return this;
    }

    /**
     * Método Auxiliar do Desenho de Elipse
     * @param cx Abscissa do Ponto Central
     * @param cy Ordenada do Ponto Central
     * @param x Deslocamento da Abscissa
     * @param y Deslocamento da Ordenada
     * @return Próprio Objeto para Encadeamento
     */
    private Canvas ellipsePoints(int cx, int cy, int x, int y)
    {
        this.put(cx +x, cy +y);
        this.put(cx -x, cy +y);
        this.put(cx -x, cy -y);
        this.put(cx +x, cy -y);
        return this;
    }

    /**
     * Desenha um Círculo no Ambiente de Desenho
     * @param cx Abscissa do Ponto Central
     * @param cy Ordenada do Ponto Central
     * @param r Tamanho do Raio
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas circle(int cx, int cy, int r)
    {
        this.ellipse(cx, cy, r, r);
        return this;
    }

    /**
     * Preenche Recursivamente o Ponto Atual e Adjacentes
     * @param x Abscissa do Ponto Inicial
     * @param y Ordenada do Ponto Inicial
     * @return Próprio Objeto para Encadeamento
     */
    public Canvas fill(int x, int y)
    {
        Stack<Point> stack = new Stack<Point>();
        int color = this.getForeground().getRGB();
        int current = image.getRGB(x, y);
        BufferedImage image = this.getImage();
        int width = image.getWidth();
        int height = image.getHeight();
        boolean inner;

        Point p;
        p = new Point(x, y);
        stack.add(p);
        while (!stack.isEmpty()) {
            this.update();
            p = stack.pop();
            inner = p.x >= 0 && p.y >= 0 && p.x < width && p.y < height;
            if (inner && image.getRGB(p.x, p.y) == current) {
                image.setRGB(p.x, p.y, color);
                if (p.x > 0) {
                    stack.push(new Point(p.x - 1, p.y));
                }
                if (p.x < width) {
                    stack.push(new Point(p.x + 1, p.y));
                }
                if (p.y > 0) {
                    stack.push(new Point(p.x, p.y - 1));
                }
                if (p.y < height) {
                    stack.push(new Point(p.x, p.y + 1));
                }
            }
        }
        return this;
    }
}
