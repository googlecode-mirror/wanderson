package br.unisinos.cs.gp.image.handler;

import java.io.*;
import java.awt.image.BufferedImage;
import br.unisinos.cs.gp.stream.LittleEndianInputStream;

/**
 * Manipulador de Imagens no Formato PCX
 * 
 * Efetua rasterização do formato especializado em uma classe padrão do Java,
 * para melhor reaproveitamento do código e padronização do projeto
 * 
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class PcxHandler implements ImageHandler
{
    @SuppressWarnings("unused")
    public BufferedImage read(File file) throws ImageHandlerException
    {
        try {

            /*
             * Abertura Padrão de Arquivo --------------------------------------
             * O formato PCX utiliza armazenamento Little Endian
             */
            FileInputStream fin = new FileInputStream(file);
            LittleEndianInputStream in = new LittleEndianInputStream(fin);

            /*
             * Cabeçalho -------------------------------------------------------
             */

            int identifier = in.readByte();
            if (identifier != 10) {
                throw new ImageHandlerException("Invalid PCX Format");
            }

            int version      = in.readByte();
            int encoding     = in.readByte();
            int bitsPerPixel = in.readByte();

            int xStart = in.readWord();
            int yStart = in.readWord();
            int xEnd   = in.readWord();
            int yEnd   = in.readWord();

            int horzRes = in.readWord();
            int vertRes = in.readWord();

            byte palette[] = new byte[48];
            in.read(palette);

            int reserved1    = in.readByte();
            int numBitPlanes = in.readByte();
            int bytesPerLine = in.readWord();
            int paletteType  = in.readWord();

            int horzScreenSize = in.readWord();
            int vertScreenSize = in.readWord();

            byte reserved2[] = new byte[54];
            in.read(reserved2);

            /*
             * Informações dos Dados -------------------------------------------
             */

            int imageWidth  = xEnd - xStart + 1;
            int imageHeight = yEnd - yStart + 1;

            int scanLineLength = numBitPlanes * bytesPerLine;

            int linePaddingSize = ((bytesPerLine * numBitPlanes) *
                (8 / bitsPerPixel)) - ((xEnd - xStart) + 1);

            /*
             * Decodificação dos Dados -----------------------------------------
             */

            int runcount, runvalue, element;
            int scannedLine[]  = new int[scanLineLength];
            int raster[][]     = new int[imageHeight][imageWidth];
            int currentLine    = 0;
            int scanLineColumn = 0;
            while (currentLine < imageHeight) {
                element = in.read();
                if ((element & 0xC0) == 0xC0) {
                    /*
                     * Se os dois bits significativos são 1, há compactação RLE
                     * e os outros 6 bits é a quantidade de repetições do
                     * próximo valor a ser lido
                     */
                    runcount = element & 0x3F;
                    runvalue = in.read();
                } else {
                    /*
                     * Caso contrário não há repetição e o valor atual deve ser
                     * repetido somente uma vez para a saída
                     */
                    runcount = 1;
                    runvalue = element;
                }
                for (int i = 0; i < runcount; i++) {
                    /*
                     * Repete os valores conforme captura de informações
                     */
                    scannedLine[scanLineColumn++] = runvalue;
                }
                if (scanLineColumn >= scanLineLength) {
                    /*
                     * Término de captura da linha descompactada
                     */
                    if (numBitPlanes == 3) {
                        /*
                         * Existem três planos na estrutura de dados, geralmente
                         * ocorre no formato de imagem de 24bits e não há paleta
                         */
                        int alpha, red, green, blue, color;
                        alpha = 255 << 24; // PCX não suporta canal alfa
                        for (int i = 0; i < imageWidth; i++) {
                            red   = scannedLine[i];
                            green = scannedLine[i + imageWidth];
                            blue  = scannedLine[i + imageWidth * 2];
                            color = alpha | red << 16 | green << 8 | blue;
                            raster[currentLine][i] = color;
                        }
                    } else if (numBitPlanes == 1) {
                        /*
                         * Há somente um plano de cor que utiliza uma paleta ao
                         * final do arquivo. Os dados devem ser armazenados e
                         * posteriormentes mapeados conforme a paleta de cores
                         */
                        for (int i = 0; i < scanLineLength; i++) {
                            raster[currentLine][i] = scannedLine[i];
                        }
                    }
                    currentLine++;
                    scanLineColumn = 0;
                }
            }
            if (numBitPlanes == 1) {
                /*
                 * O arquivo trabalha com somente um plano de cor e deve ser
                 * mapeado conforme paleta de cores do final do arquivo
                 */
                byte triples[] = new byte[768];
                if (in.read() != 0x0C || in.read(triples) == -1) {
                    /*
                     * Existe um erro com o identificador da paleta (número
                     * inteiro 12) ou não existe 768 bits necessários para
                     * preenchimento da paleta de cores
                     */
                    throw new ImageHandlerException("Palette Error");
                }
                int palette2[] = new int[256];
                int alpha, red, green, blue, color;
                alpha = 255 << 24;
                for (int i = 0; i < 256; i++) {
                    /*
                     * Construção da paleta de cores
                     */
                    red   = triples[i*3];
                    green = triples[i*3+1];
                    blue  = triples[i*3+2];
                    color = alpha | red << 16 | green << 8 | blue;
                    palette2[i] = color;
                }
                for (int y = 0; y < imageHeight; y++) {
                    for (int x = 0; x < imageWidth; x++) {
                        /*
                         * Remapeamento da informação para a paleta de cores
                         * disponibilizada no final do arquivo
                         */
                        raster[y][x] = palette2[raster[y][x]];
                    }
                }
            }

            /*
             * Construção do Objeto --------------------------------------------
             */
            BufferedImage image = new BufferedImage(imageWidth, imageHeight,
                BufferedImage.TYPE_INT_ARGB);
            for (int y = 0; y < imageHeight; y++) {
                for (int x = 0; x < imageWidth; x++) {
                    image.setRGB(x, y, raster[y][x]);
                }
            }

            /*
             * Finalização -----------------------------------------------------
             */

            in.close();
            fin.close();
            return image;

        } catch (FileNotFoundException e) {
            throw new ImageHandlerException("File Not Found");
        } catch (IOException e) {
            throw new ImageHandlerException("Input/Output Error");
        }
    }
}
