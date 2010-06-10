package machine;

import java.io.*;

/**
 * Classe Pacote
 * Informações para Envio Empacotadas
 * 
 * @author Wanderson Henrique Camargo Rosa
 *
 */
public class Pack implements Serializable
{
    /**
     * Número do Serializável
     */
    private static final long serialVersionUID = -313043130300249180L;

    /**
     * Checagem de Resposta Concluída
     */
    protected boolean ack = false;

    /**
     * Checagem de Pedido de Conexão
     */
    protected boolean sin = false;

    /**
     * Tamanho da Janela de Conexão
     */
    protected int sizeWindow = 1;

    /**
     * Número de Ack
     */
    protected int nAck;

    /**
     * Número de Sequência
     */
    protected int nSeq;

    /**
     * Conteúdo do Pacote
     */
    protected String content;

    /**
     * Construtor da Classe
     * @param content Conteúdo do Pacote
     */
    public Pack(String content)
    {
        this.content = content;
    }

    /**
     * Informa o Conteúdo do Pacote
     * @return Conteúdo Solicitado
     */
    public String getContent()
    {
        return this.content;
    }

    public String toString()
    {
        return this.getNumberSeq() + ": " + this.getContent();
    }

    /**
     * Configura a Verificação de Elemento de Resposta
     * @param flag Identificador de Resultado
     * @return Próprio Objeto
     */
    public Pack setAck(boolean flag)
    {
        this.ack = flag;
        return this;
    }

    /**
     * Configura a Verificação de Início de Conexão
     * @param flag Identificador de Resultado
     * @return Próprio Objeto
     */
    public Pack setSin(boolean flag)
    {
        this.sin = flag;
        return this;
    }

    /**
     * Configura o Tamanho da Janela
     * @param size Configuração do Tamanho da Janela
     * @return Próprio Objeto
     */
    public Pack setSizeWindow(int size)
    {
        if (size <= 0) {
            size = 1;
        }
        this.sizeWindow = size;
        return this;
    }

    /**
     * Configura o Número de Confirmação para Próximo Passo
     * @param number Número de Resposta
     * @return Próprio Objeto
     */
    public Pack setNumberAck(int number)
    {
        this.nAck = number;
        return this;
    }

    /**
     * Informa o Número de Confirmação para Próximo Passo
     * @return Próprio Objeto
     */
    public int getNumberAck()
    {
        return this.nAck;
    }

    /**
     * Configura o Número de Sequência do Passo Atual
     * @param number Número de Sequência
     * @return Próprio Objeto
     */
    public Pack setNumberSeq(int number)
    {
        this.nSeq = number;
        return this;
    }

    /**
     * Informa o Número de Sequência do Passo Atual
     * @return Número de Sequência
     */
    public int getNumberSeq()
    {
        return this.nSeq;
    }

    /**
     * Informa o Tamanho da Janela da Conexão
     * @return Tamanho da Janela
     */
    public int getSizeWindow()
    {
        return this.sizeWindow;
    }

    /**
     * Informa a Verificação de Ack
     * @return Informação Solicitada
     */
    public boolean isAck()
    {
        return this.ack;
    }

    /**
     * Informa um Início de Conexão
     * @return Informação Solicitada
     */
    public boolean isSin()
    {
        return this.sin;
    }
}
