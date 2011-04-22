package br.nom.camargo.wanderson.presenter;

import java.util.Calendar;

import android.content.ContentValues;

/**
 * Dispositivo
 * 
 * Classe para encapsulamento das regras de negócio sobre dispositivos locais.
 * Utilizada pelo modelo para verificação dos dados para inserção no banco.
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
public class DeviceElement
{
    /**
     * Nome do Dispositivo
     */
    private String name;

    /**
     * Tipo do Dispositivo
     */
    private Type type;

    /**
     * Endereço de Conexão com o Dispositivo
     */
    private String address;

    /**
     * Porta para Conexão
     */
    private String port;

    /**
     * Configura o Nome do Dispositivo
     * @param name Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public DeviceElement setName(String name)
    {
        this.name = name;
        return this;
    }

    /**
     * Informa o Nome do Dispositivo
     * @return Elemento para Informação
     */
    public String getName()
    {
        return name;
    }

    /**
     * Configura o Tipo do Dispositivo
     * @param type Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public DeviceElement setType(Type type)
    {
        this.type = type;
        return this;
    }

    /**
     * Informa o Tipo do Dispositivo
     * @return Elemento para Informação
     */
    public Type getType()
    {
        return this.type;
    }

    /**
     * Configura o Endereço do Dispositivo
     * Consulta o Tipo de Dispositivo e Verifica Valor Informado
     * @param address Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public DeviceElement setAddress(String address)
    {
        switch (getType()) {
        case Bluetooth:
            /* @todo Verificação de Dados */
            this.address = address;
            break;
        case Ethernet:
            /* @todo Verificação de Dados */
            this.address = address;
            break;
        }
        return this;
    }

    /**
     * Informa o Endereço de Dispositivo
     * @return Elemento para Informação
     */
    public String getAddress()
    {
        return address;
    }

    /**
     * Configura a Porta para Conexão
     * Consulta o Tipo de Dispositivo e Verifica Valor Informado
     * @param port Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public DeviceElement setPort(String port)
    {
        switch (getType()) {
        case Bluetooth:
            /* @todo Verificação de Dados */
            this.port = port;
            break;
        case Ethernet:
            /* @todo Verificação de Dados */
            this.port = port;
            break;
        }
        return this;
    }

    /**
     * Informa a Porta para Conexão
     * @return Elemento para Informação
     */
    public String getPort()
    {
        return port;
    }

    public ContentValues getContentValues()
    {
        ContentValues content = new ContentValues();

        /* Conteúdo do Dispositivo */
        content.put("name", getName());
        content.put("type", getType().toString());
        content.put("address", getAddress());
        content.put("port", getPort());
        /* Última Atualização */
        content.put("updated", Calendar.getInstance().get(Calendar.DATE));

        return content;
    }

    /**
     * Tipo de Elemento de Dispositivo
     * 
     * @author Wanderson Henrique Camargo Rosa
     */
    public enum Type
    {
        Bluetooth, Ethernet;
    }
}
