package main;

import java.util.*;
import machine.*;

/**
 * Classe Principal
 * Simulação do Sistema
 * 
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Main {

    /**
     * Método Principal
     * @param args Argumentos
     */
    public static void main(String[] args)
    {
        Pack pack;
        String line;
        String elements[];
        Machine machine = new Machine();

        machine.start();
        machine.setAddress("127.0.0.1");

        Scanner scanner = new Scanner(System.in);
        while (!(line = scanner.nextLine()).isEmpty()) {
            elements = line.trim().split(" ");
            for (int i = 0; i < elements.length; i++) {
                pack = new Pack(elements[i]);
                pack.setNumberSeq(i);
                machine.send(pack);
            }
        }

        while ((pack = machine.retrieve()) != null) {
            System.out.println("Spool: " + pack);
        }

        machine.stop();
    }

}
