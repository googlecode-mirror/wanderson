package cs.complex.floydwarshall;

import cs.estrutav.graph.*;
import cs.estrutav.graph.Number;
import java.util.*;

/**
 * Floyd-Wardshall Algorithm
 * @author Douglas Carpenedo
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class FloydWarshall {
	
	/*
	 * Class Variables
	 */
	
	/**
	 * Graph
	 */
	private Graph graph;
	
	/*
	 * Constructors
	 */
	
	/**
	 * Complete Constructor
	 * @param graph Graph
	 * @throws FloydWarshallException Null Graph Pointer
	 * @throws GraphException Graph Error
	 */
	public FloydWarshall(Graph graph) throws FloydWarshallException, GraphException {
		this
			.setGraph(graph)
			.execute();
	}
	
	/*
	 * Methods
	 */
	
	/**
	 * Run Floyd-Warshall Algorithm
	 * @return Self Object
	 * @throws FloydWarshallException Execute Error
	 * @throws GraphException Graph Error
	 */
	private FloydWarshall execute() throws FloydWarshallException, GraphException {
		Graph graph = this.getGraph();
		if(graph == null)
			throw new FloydWarshallException();
		
		Number infinite = new Number(Number.INFINITE);
		
		int counter = graph.getNumberOfVertices();
		Content matrix[][] = new Content[counter][counter];
		
		ArrayList<Vertice> vertices = graph.getVertices();
		Edge edge = null;
		
		for(int y = 0; y < counter; y++) {
			for(int x = 0; x < counter; x++) {
				if(x != y) {
					try {
						edge = vertices.get(y).visit(vertices.get(x));
						
						edge.visitFrom(vertices.get(y));
						
						matrix[y][x] = edge.getContent();
					}
					catch(GraphException e) {
						matrix[y][x] = infinite;
					}
				}
				else {
					matrix[y][x] = infinite;
				}
			}
		}
		
		Content pivot[][] = new Content[counter][counter];
		for(int i = 0; i < counter; i++)
			for(int j = 0; j < counter; j++)
				pivot[i][j] = infinite;
		
		int a,b,c;
		for(int k = 0; k < counter; k++) {
			for(int i = 0; i < counter; i++) {
				for(int j = 0; j < counter; j++) {
					a = ((Number)matrix[i][k]).getContent();
					b = ((Number)matrix[k][j]).getContent();
					c = ((Number)matrix[i][j]).getContent();
					if(a != Number.INFINITE.intValue())
						if(b != Number.INFINITE.intValue()) {
							if(c != a+b) {
								int min = this.findMin(c, a, b);
								if(min == a + b)
									pivot[i][j] = new Number(k);
							}
						}
					matrix[i][j] = new Number(findMin(c, a, b));
				}
			}
		}
		
		int swap = 0;
		System.out.println("Adjacencias:");
		for (int x = 0; x < counter; x++) {
			for (int y = 0; y < counter; y++) {
				swap = ((Number)matrix[x][y]).getContent().intValue() == Integer.MAX_VALUE ? -1 : ((Number)matrix[x][y]).getContent();
				System.out.print(swap + "\t");
			}
			System.out.println();
		}
		System.out.println();
		System.out.println();
		
		System.out.println("Pivos:");
		for (int x = 0; x < counter; x++) {
			for (int y = 0; y < counter; y++) {
				swap = ((Number)pivot[x][y]).getContent().intValue() == Integer.MAX_VALUE ? -1 : ((Number)matrix[x][y]).getContent();
				System.out.print(swap + "\t");
			}
				
			System.out.println();
		}
		System.out.println();
		System.out.println();
		
		return this;
	}
	
	/**
	 * Find Minimal Value from Algorithm
	 * @param a First int Value
	 * @param b Second int Value
	 * @param c Third int value
	 * @return Minimal Value
	 */
	public int findMin(int a, int b, int c) {
		int infinite = Number.INFINITE;
		if(b == infinite || c == infinite)
			return a;
		if(a < b + c)
			return a;
		return b + c;
	}
	
	/*
	 * Setters
	 */
	
	/**
	 * Configures Graph
	 * @param graph Graph
	 * @return Self Object
	 * @throws FloydWarshallException Null Graph Pointer
	 */
	private FloydWarshall setGraph(Graph graph) throws FloydWarshallException {
		if(graph == null)
			throw new FloydWarshallException();
		this.graph = graph;
		return this;
	}
	
	/**
	 * Returns Graph
	 * @return Graph
	 */
	public Graph getGraph() {
		return this.graph;
	}
}
