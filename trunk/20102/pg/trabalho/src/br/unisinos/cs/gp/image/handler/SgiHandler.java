package br.unisinos.cs.gp.image.handler;

import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.RandomAccessFile;
import java.util.ArrayList;

/**
 * Manipulador de Imagens no Formato SGI
 * 
 * Efetua rasterização do formato especializado em uma classe padrão do Java,
 * para melhor reaproveitamento do código e padronização do projeto
 * 
 * @author Roberto Raguze Flores
 */
public class SgiHandler implements ImageHandler {

	@SuppressWarnings("unused")
	public BufferedImage read(File file) throws ImageHandlerException {
		 try {

	            /*
	             * Abertura Padrão de Arquivo --------------------------------------
	             * O formato SGI utiliza Big Endian
	             */

	            RandomAccessFile in = new RandomAccessFile(file, "r");

	            /*
	             * Cabeçalho -------------------------------------------------------
	             */
	            
	            int magic = in.readUnsignedShort();
	            
	            if (magic != 474) {
	                throw new ImageHandlerException("Invalid SGI Format");
	            }

	            char storage = (char)in.readUnsignedByte();
	            char bcp     = (char)in.readUnsignedByte();
	            
	            int dimension = in.readUnsignedShort();
	            int xSize     = in.readUnsignedShort();
	            int ySize     = in.readUnsignedShort();
	            int zSize     = in.readUnsignedShort();
	            
	            int pixMin = in.readInt();
	            int pixMax = in.readInt();
	            
	            byte dummy1[] = new byte[4];
	            in.read(dummy1);
	            
	            StringBuilder nameBuilder = new StringBuilder();
	            for(int i=0; i<80; i++) {
	            	nameBuilder.append((char)in.readUnsignedByte());
	            }
	            String imageName = nameBuilder.toString();
	            
	            int colorMap = in.readInt();
	            
	            byte dummy2[] = new byte[404];
	            in.read(dummy2);
	         
	            /*
	             * Decodificação dos Dados -----------------------------------------
	             */
	            
	            int tableLength   = ySize * zSize;
	            int startTable[]  = new int[tableLength];
	            int lenghtTable[] = new int[tableLength];

	            /*
	             * Somente ler as tabelas de offset e data lenght se a image utilizar
	             * compacta��o RLE. O par�metro Storage determina se a imagem foi 
	             * compactada.
	             * 
	             * Storage = 0 > Verbatim mode
	             * Storage = 1 > RLE mode
	             */
	            if(storage == 1) {
	            	for(int i = 0; i < startTable.length; i++) {
	            		startTable[i] = in.readInt();
	            	}
	            	for(int i = 0; i < lenghtTable.length; i++) {
	            		lenghtTable[i] = in.readInt();
	            	}
	            }
	            
	            byte buffer[]  = new byte[xSize];
	            byte pixelMap[][][] = new byte[zSize][ySize][xSize];  
	            
	            for(int z = 0; z < zSize; z++) {
	            	for(int y = 0; y < ySize; y++) {
	            		if (storage == 1 ) {
	            			/*
	            			 * 
	            			 */
	            			in.seek(startTable[y+z*ySize]);
	            			in.read(buffer, 1, lenghtTable[y+z*ySize]);
	            			boolean exit = false;
	            			while(exit != true) {
	            				int inputIndex = 0;
	            				int outputIndex = 0;
	            				byte pixel = buffer[inputIndex++];
	            				int count = (int)(pixel & 0x7F);
	            				if (count <= 0) {
	            					exit = true;
	            				}
	            				/*
	            				 * 
	            				 */
	            				if ((pixel & 0x80) > 0 ) {
	            					while (count-- > 0) {
	            						pixelMap[z][y][outputIndex++] = buffer[inputIndex++];
	            					}
	            				/*
	            				 * 
	            				 */
	            				} else {
	            					pixel = buffer[inputIndex++];
	            					while (count-- > 0) {
	            						pixelMap[z][y][outputIndex++] = pixel;
	            					}	
	            				}
	            			}
	            		} else {
	            			/*
	            			 * 
	            			 */
	            			in.seek(512+(y*xSize)+(z*xSize*ySize));
	            			in.read(pixelMap[z][y], 1, xSize);
	            		}
	            	}
	            }
	            
	            /*
	             * 
	             */
	            int raster[][] = null;
	            switch(zSize) {
	            case 4:	raster = this.rgbaToRgba(pixelMap, ySize, xSize); break;
	            case 3: raster = this.rgbToRgba(pixelMap, ySize, xSize);  break;
	            case 2: break;
	            case 1: break;
	            default:
	            	break;
	            }
	            
	            /*
	             * Construção do Objeto --------------------------------------------
	             */

	            BufferedImage image = new BufferedImage(xSize, ySize,
	                BufferedImage.TYPE_INT_ARGB);
	            for (int y = 0; y < ySize; y++) {
	                for (int x = 0; x < xSize; x++) {
	                    image.setRGB(x, y, raster[y][x]);
	                }
	            }

	            /*
	             * Finalização -----------------------------------------------------
	             */

	            in.close();
	            return image;
	            
		 } catch (FileNotFoundException e) {
			 throw new ImageHandlerException("File Not Found");
	     } catch (IOException e) {
	         throw new ImageHandlerException("Input/Output Error");
	     }
	}
	
	private int[][] rgbaToRgba(byte[][][] pixelMap, int ySize, int xSize) {
		int raster[][] = new int[pixelMap[0].length][pixelMap[0][0].length];
		for(int y = 0; y < ySize; y++) {
			for(int x = 0; x < xSize; x++) {
				raster[y][x] = (pixelMap[4][y][x] << 24) | (pixelMap[0][y][x] << 16) |
							   (pixelMap[1][y][x] << 8) | pixelMap[2][y][x];
			}
		}
		return raster;
	}
	
	private int[][] rgbToRgba(byte[][][] pixelMap, int ySize, int xSize) {
		int raster[][] = new int[pixelMap[0].length][pixelMap[0][0].length];
		for(int y = 0; y < ySize; y++) {
			for(int x = 0; x < xSize; x++) {
				int alpha = 0xFF;
				int red   = pixelMap[0][y][x];
				int green = pixelMap[1][y][x];
				int blue  = pixelMap[2][y][x];
				raster[y][x] = (alpha << 24) | (red << 16) | (green << 8) | red;
			}
		}
		return raster;
	}

}
