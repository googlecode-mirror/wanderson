package cs.piana.vliw;

import java.util.*;
import cs.piana.memory.*;

/**
 * Piana Very Long Instruction Word
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Vliw {
	
	/**
	 * Pipeline Names
	 */
	private String pipelines[];
	
	/**
	 * Instructions List
	 */
	private ArrayList<Object> pipes;
	
	/**
	 * Complete Constructor
	 * @param pipelines Pipeline Names
	 */
	public Vliw(String pipelines[]) {
		this
			.setPipelines(pipelines);
		
		int count = pipelines.length;
		pipes = new ArrayList<Object>();
		for(int i = 0; i < count; i++)
			pipes.add(new ArrayList<Instruction>());
		
		
	}
	
	/**
	 * Configure Pipelines
	 * @param pipelines Pipeline Names
	 * @return Self Object
	 */
	public Vliw setPipelines(String pipelines[]) {
		this.pipelines = pipelines;
		return this;
	}
	
	/**
	 * Return Pipelines
	 * @return Pipeline Names
	 */
	public String[] getPipelines() {
		return this.pipelines;
	}
}
