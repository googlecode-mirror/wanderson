package br.unisinos.cs.gp.parallax;

import java.awt.image.BufferedImage;

/**
 * Camada de Visualização
 * 
 * Trabalha para exibição de imagens em um plano interno à visualização
 * primária. Responsável pela posição no espaço e velocidade de deslocamento
 * do efeito Parallax
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class Layer extends BufferedImage
{
    /**
     * Abscissa do Plano
     */
    private int x;

    /**
     * Ordenada do Plano
     */
    private int y;

    /**
     * Velocidade de Deslocamento
     */
    private double speed;

    /**
     * Construtor da Classe
     * @param width  Largura
     * @param height Altura
     */
    public Layer(int width, int height)
    {
        super(width, height, BufferedImage.TYPE_INT_ARGB);
    }

    /**
     * Encapsulamento para Configuração de Valor da Abscissa
     * @param x Novo valor aplicável
     * @return Próprio Objeto
     */
    public Layer setX(int x)
    {
        this.x = x;
        return this;
    }

    /**
     * Encapsulamento para Configuração de Valor da Ordenada
     * @param y Novo valor aplicável
     * @return Próprio Objeto
     */
    public Layer setY(int y)
    {
        this.y = y;
        return this;
    }

    /**
     * Encapsulamento para Configuração da Valocidade de Deslocamento da Camada
     * @param speed Novo valor aplicável
     * @return Próprio Objeto
     */
    public Layer setSpeed(double speed)
    {
        this.speed = speed;
        return this;
    }

    /**
     * Encapsulamento para Acesso ao Valor da Abscissa
     * @return Valor solicitado
     */
    public int getX()
    {
        return x;
    }

    /**
     * Encapsulamento para Acesso ao Valor da Ordenada
     * @return Valor solicitado
     */
    public int getY()
    {
        return y;
    }

    /**
     * Encapsulamento para Acesso ao Valor da Velocidade Atual de Deslocamento
     * @return Valor solicitado
     */
    public double getSpeed()
    {
        return speed;
    }
}