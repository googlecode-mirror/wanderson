package cs.piana.parser;

import cs.piana.memory.*;
import java.io.*;

/**
 * Piana Parser
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Parser {
	
	/**
	 * Parse an Assembly Program to Piana Memory
	 * @param filename Filename to Parse
	 * @return Memory Created
	 * @throws ParserException Parser Error
	 */
	public static Memory parse(String filename) throws ParserException {
		Memory memory = new Memory();
		
		try {
			BufferedReader in = new BufferedReader(new FileReader(filename));
			
			String line = null;
			String splitted[] = null;
			String name, out, in1, in2;
			name = out = in1 = in2 = null;
			Instruction block;
			
			while((line = in.readLine()) != null) {
				
				splitted = line.split(" ");
				if(splitted.length != 2)
					throw new ParserException(ParserException.PARSER_ERROR);
				
				name = splitted[0];
				
				splitted = splitted[1].split(",");
				if(splitted.length != 3)
					throw new ParserException(ParserException.PARSER_ERROR);
				
				out = splitted[0];
				in1 = splitted[1];
				in2 = splitted[2];
				
				block = new Instruction(out, in1, in2);
				
				if(name.compareTo("ADD") == 0)
					block.setTtl(1);
				else if(name.compareTo("SUB") == 0)
					block.setTtl(1);
				else if(name.compareTo("MUL") == 0)
					block.setTtl(2);
				else
					throw new ParserException(ParserException.PARSER_ERROR);
				
				memory.addBlock(block);
			}
		}
		catch(FileNotFoundException e) {
			throw new ParserException(ParserException.PARSER_ERROR);
		}
		catch(IOException e) {
			throw new ParserException(ParserException.PARSER_ERROR);
		}
		catch(InstructionException e) {
			throw new ParserException(ParserException.PARSER_ERROR);
		}
		
		return memory;
	}
}
