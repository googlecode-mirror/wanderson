package br.unisinos.cs.gp.parallax;

import java.io.File;
import javax.swing.JFileChooser;
import javax.swing.filechooser.FileFilter;

/**
 * Caixa de Escolha de Arquivos de Imagem
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class ParallaxEditorImageChooser extends JFileChooser
{
    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 8860528925772969473L;

    /**
     * Construtor da Classe
     */
    public ParallaxEditorImageChooser()
    {
        this.addChoosableFileFilter(new ParallaxEditorFilterPng());
        this.addChoosableFileFilter(new ParallaxEditorFilterPcx());
    }

    /**
     * Informativo da Classe de Manipulação de Imagem
     * @return Caminho completo da Classe Manipuladora
     */
    public String getType()
    {
        String description = this.getFileFilter().getDescription();
        if (description.equals("PNG Image")) {
            return "br.unisinos.cs.gp.image.handler.PngHandler";
        }
        if (description.equals("PCX Image")) {
            return "br.unisinos.cs.gp.image.handler.PcxHandler";
        }
        return null;
    }

    /**
     * Classe Aninhada para Filtro de Arquivos PNG
     * @author Wanderson Henrique Camargo Rosa
     */
    class ParallaxEditorFilterPng extends FileFilter
    {
        public boolean accept(File archive)
        {
            return archive.isDirectory()
                || archive.getName().toLowerCase().endsWith("png");
        }

        public String getDescription()
        {
            return "PNG Image";
        }
    }

    /**
     * Classe Aninhada para Filtro de Arquivos PCX
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    class ParallaxEditorFilterPcx extends FileFilter
    {
        public boolean accept(File archive) {
            return archive.isDirectory()
                || archive.getName().toLowerCase().endsWith("pcx");
        }

        public String getDescription() {
            return "PCX Image";
        }
    }
}
