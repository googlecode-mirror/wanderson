package br.nom.camargo.wanderson.renato.adapter;

import java.io.InputStream;
import java.io.OutputStream;

/**
 * Adaptador de Conexão
 * 
 * Utilizado pelo servidor de mensagens para tornar a transferência de dados
 * transparente utilizando o padrão de projeto Adapter. Encapsulamento de 
 * execução específica para cada tipo de conexão.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public abstract class ConnectionAdapter
{
    /**
     * Etiqueta para Log do Sistema
     */
    public static final String TAG = "ConnectionAdapter";

    /**
     * Fluxo para Entrada de Dados
     */
    private InputStream input;

    /**
     * Fluxo para Saída de Dados
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
        return input;
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
        return output;
    }

    /**
     * Conexão com Dispositivos
     * Deve criar uma conexão com máquinas locais utilizando especificações
     * específicas de adaptador.
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
