package br.unisinos.cs.gp.image.handler;

import java.io.*;
import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;

/**
 * Manipulador de Imagens PNG
 * Trabalha como Interface para Leitor de Imagens do Java
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class PngHandler implements ImageHandler
{
    public BufferedImage read(File file) throws ImageHandlerException
    {
        try {
            BufferedImage image = ImageIO.read(file);
            return image;
        } catch (IOException e) {
            throw new ImageHandlerException(e.getMessage());
        }
    }

}
