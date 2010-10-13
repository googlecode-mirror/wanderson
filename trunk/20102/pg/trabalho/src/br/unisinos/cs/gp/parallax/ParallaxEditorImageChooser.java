package br.unisinos.cs.gp.parallax;

import java.io.File;
import javax.swing.JFileChooser;
import javax.swing.filechooser.FileFilter;

public class ParallaxEditorImageChooser extends JFileChooser
{
    private static final long serialVersionUID = 8860528925772969473L;

    public ParallaxEditorImageChooser()
    {
        this.addChoosableFileFilter(new ParallaxEditorFilterPng());
        this.addChoosableFileFilter(new ParallaxEditorFilterPcx());
    }

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
