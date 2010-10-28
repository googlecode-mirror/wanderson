package br.unisinos.cs.gp.image;

import java.io.File;
import java.awt.image.BufferedImage;
import br.unisinos.cs.gp.image.handler.*;

/**
 * Carregador de Imagens
 * 
 * Trabalha sobre o padrão de projeto Factory que possibilita através de um
 * método estático criar um novo objeto de uma família específica. Necessário
 * pois torna a criação facilitada de novas classes de manipulação de imagens,
 * externas ao pacote.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ImageLoader
{
    /**
     * Padrão de Projeto Factory
     * @param filename Nome do Arquivo para Carregamento
     * @param handler  Classe de Manipulação de Imagens
     * @return Normalização da Imagem em Objeto Comum ao Java
     * @throws ImageHandlerException Erros Internos de Carregamento
     */
    public static BufferedImage factory(String filename, String handler)
        throws ImageHandlerException
    {
        try {
            /*
             * Classes externas ao pacote podem ser utilizadas, onde somente é
             * necessário que implementem a classe de manipulação de imagens
             */
            ImageHandler reader =
                (ImageHandler) Class.forName(handler).newInstance();
            return reader.read(new File(filename));
        } catch (InstantiationException e) {
            throw new ImageHandlerException("Instantiation Exception");
        } catch (IllegalAccessException e) {
            throw new ImageHandlerException("Illegal Access Exception");
        } catch (ClassNotFoundException e) {
            throw new ImageHandlerException("Class Not Found");
        }
    }
}
