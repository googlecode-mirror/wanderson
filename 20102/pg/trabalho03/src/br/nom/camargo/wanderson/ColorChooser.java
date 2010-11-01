package br.nom.camargo.wanderson;

import java.awt.*;
import javax.swing.*;

public class ColorChooser extends JComboBox
{
    /**
     * 
     */
    private static final long serialVersionUID = 183037896267359785L;

    public ColorChooser()
    {
        super();
        this.addItem(Color.WHITE);
        this.addItem(Color.BLACK);
        this.addItem(Color.RED);
        this.addItem(Color.GREEN);
        this.addItem(Color.BLUE);
    }
}
