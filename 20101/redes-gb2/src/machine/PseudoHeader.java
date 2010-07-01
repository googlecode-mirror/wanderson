package machine;

/**
 * Pseudo-Cabeçalho
 * Classe Estática para Criação e Checagem de Conteúdo de Pacotes
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class PseudoHeader
{
    /**
     * Tabela de Pesquisa
     */
    private static String[] lookup = {
        "0+0+0=00",
        "0+0+1=01",
        "0+1+0=01",
        "0+1+1=10",
        "1+0+0=01",
        "1+0+1=10",
        "1+1+0=10",
        "1+1+0=10",
        "1+1+1=11"
    };

    /**
     * Gerador de Checksum do Pacote
     * @param element Pacote para Leitura
     * @return Checksum do Pacote
     */
    public static String generateChecksum(PacoteTCP element)
    {
        String content[] = PseudoHeader.getFormatedString(element.toString());
        String result    = content[0];
        for (int i = 1; i < content.length; i++) {
            result = PseudoHeader.add(result, content[i]);
        }
        return result;
    }

    /**
     * Grava o Complemento do Checksum no Pacote
     * @param element Pacote para Gravação
     */
    public static void recordChecksum(PacoteTCP element)
    {
        String result = PseudoHeader.generateChecksum(element);
        result = PseudoHeader.complement(result);
        element.setChecksum(result);
    }

    /**
     * Checagem de Integridade de Pacote
     * @param element Pacote para Verificação
     * @return Resultado da Pesquisa
     */
    public static boolean checksum(PacoteTCP element)
    {
        String checksum = PseudoHeader.generateChecksum(element);
        String result   = PseudoHeader.add(checksum, element.getChecksum());
        return result.equals("1111111111111111");
    }

    /**
     * Gerador de Elementos para Cálculo de Checksum
     * @param element Conteúdo do Pacote
     * @return Elementos para Cálculo
     */
    private static String[] getFormatedString(String element)
    {
        String content[];
        int size = element.length();

        if (size % 2 != 0) {
            content = new String[size + 1];
            content[content.length - 1] = "00000000";
        } else {
            content = new String[size];
        }

        String binary;
        for (int i = 0; i < size; i++) {
            binary = Integer.toBinaryString(element.charAt(i));
            content[i] = binary;
            while (content[i].length() < 8) {
                content[i] = "0" + content[i];
            }
        }

        String checksum[] = new String[content.length / 2];
        for (int i = 0, j =0; i < checksum.length; i++, j+=2) {
            checksum[i] = content[j] + content[j+1];
        }
        return checksum;
    }

    /**
     * Pesquisa Sobre Tabela de Informações
     * @param b1 Binário
     * @param b2 Binário
     * @param c  Carry
     * @return Resultado da Pesquisa
     */
    private static String lookup(char b1, char b2, char c)
    {
        String formula = String.format("%c+%c+%c=", b1, b2, c);
        String result  = "";
        for (String search : lookup) {
            if (search.startsWith(formula)) {
                result = search.substring(search.indexOf("=") + 1);
            }
        }
        return result;
    }

    /**
     * Adição de Valores Binários
     * @param s1 Valor Binário
     * @param s2 Valor Binário
     * @return Resultado do Somatório
     */
    private static String add(String s1, String s2)
    {
        String temp;
        String result = "";
        char carry = '0';
        for (int i = 15; i >= 0; i--) {
            temp = PseudoHeader.lookup(s1.charAt(i), s2.charAt(i), carry);
            result = temp.charAt(1) + result;
            carry  = temp.charAt(0);
        }
        if (carry == '1') {
            result = PseudoHeader.add(result, "0000000000000001");
        }
        return result;
    }

    /**
     * Complemento de Valor Binário
     * @param s1 Valor Binário
     * @return Resultado do Complemento
     */
    private static String complement(String s1)
    {
        String result = "";
        for (int i = 0; i < s1.length(); i++) {
            result = result + (s1.charAt(i) == '0' ? '1' : '0');
        }
        return result;
    }
}
