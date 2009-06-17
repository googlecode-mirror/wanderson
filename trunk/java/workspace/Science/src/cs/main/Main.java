package cs.main;

import cs.piana.*;
import cs.piana.memory.*;
import cs.piana.parser.*;

/**
 * Computer Science Main Class
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Main {
	/**
	 * Main Method
	 * @param args Terminal Arguments
	 */
	public static void main(String args[]) {
		
		try {
			Memory memory = Parser.parse("asm/code.asm");
			
			
		}
		catch(PianaException e) {
			System.out.println();
		}
		
	}
}
