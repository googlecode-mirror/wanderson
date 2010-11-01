package br.nom.camargo.wanderson;

import javax.swing.*;

/**
 * Caixa de Escolha de Elemento Geométrico
 *
 * @author Wanderson Henrique Camargo Rosa
 */
public class GeometricChooser extends JComboBox
{

    /**
     * Número de Serialização
     */
    private static final long serialVersionUID = 1209206602226936536L;

    /**
     * Construtor Padrão
     */
    public GeometricChooser()
    {
        super();
        for (Geometric g : Geometric.values()) {
            this.addItem(g);
        }
    }
}
