package cs.main;

import cs.piana.*;
import cs.piana.memory.*;
import cs.piana.parser.*;
import cs.piana.vliw.Vliw;
import cs.piana.vliw.VliwTree;

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
			String pipes[] = {"ADD","ADD","MUL"};
			Vliw vliw = new Vliw(pipes);
			VliwTree tree = vliw.createTree(memory);
			Instruction instruction = tree.removeInstruction("ADD");
			tree.removeInstruction("ADD");
			tree.removeInstruction("MUL");
			tree.removeInstruction("ADD");
			tree.removeInstruction("ADD");
			tree.removeInstruction("MUL");
			
			System.out.println();
		}
		catch(PianaException e) {
			System.out.println();
		}
		
	}
}
