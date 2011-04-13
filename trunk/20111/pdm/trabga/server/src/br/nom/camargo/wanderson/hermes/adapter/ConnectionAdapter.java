package br.nom.camargo.wanderson.hermes.adapter;

import java.io.InputStream;
import java.io.OutputStream;

/**
 * Adaptador de Conexão
 * 
 * Abstração de dados para conexão no servidor de mensagens. Trabalha como um
 * intermediário entre comunicação específica entre dispositivos e serviço de
 * mensagens. Baseado no padrão de projeto Adapter.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public abstract class ConnectionAdapter
{
    /**
     * Fluxo para Entrada de Dados
     */
    private InputStream input;

    /**
     * Fluxo de Saída de Dados
     */
    private OutputStream output;

    /**
     * Configuração do Fluxo de Entrada de Dados
     * @param input Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    protected ConnectionAdapter setInputStream(InputStream input)
    {
        this.input = input;
        return this;
    }

    /**
     * Informação do Fluxo de Entrada de Dados
     * @return Elemento de Informação
     */
    public InputStream getInputStream()
    {
        return this.input;
    }

    /**
     * Configuração do Fluxo de Saída de Dados
     * @param output Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    protected ConnectionAdapter setOutputStream(OutputStream output)
    {
        this.output = output;
        return this;
    }

    /**
     * Informação do Fluxo de Saída de Dados
     * @return Elemento de Informação
     */
    public OutputStream getOutputStream()
    {
        return this.output;
    }

    /**
     * Conexão com Dispositivos
     * Deve criar uma nova conexão com dispositivos remotos utilizando
     * especializações específicos do adaptador
     * @return Próprio Objeto para Encadeamento
     * @throws ConnectionException Erro ao Conectar
     */
    public abstract ConnectionAdapter connect() throws ConnectionException;

    /**
     * Desconexão com Dispositivos
     * Fecha uma conexão anteriormente aberta
     * @return Próprio Objeto para Encadeamento
     */
    public abstract ConnectionAdapter disconnect();

    /**
     * Verificação de Conexão Ativa
     * @return Informação sobre existência de uma conexão aberta e ativa
     */
    public abstract boolean isConnected();
}
