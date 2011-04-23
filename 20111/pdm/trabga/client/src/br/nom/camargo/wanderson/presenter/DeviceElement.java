package br.nom.camargo.wanderson.presenter;

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
     * Última Utilização do Dispositivo
     */
    private String update;

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

    /**
     * Configura a Última Utilização do Dispositivo
     * @param update Elemento para Configuração
     * @return Próprio Objeto para Encadeamento
     */
    public DeviceElement setUpdate(String update)
    {
        this.update = update;
        return this;
    }

    /**
     * Informa a Última Utilização do Dispositivo
     * @return Elemento de Informação
     */
    public String getUpdate()
    {
        return update;
    }

    /**
     * Informa o Conteúdo do Dispositivo
     * @return Manipulador de Valores
     */
    public ContentValues getContentValues()
    {
        ContentValues content = new ContentValues();

        /* Conteúdo do Dispositivo */
        content.put("name", getName());
        content.put("type", getType().toString());
        content.put("address", getAddress());
        content.put("port", getPort());
        content.put("updated", getUpdate());

        return content;
    }

    /**
     * Comparação de Igualdade
     * Trabalha Sobre Nome e Tipo de Objeto
     * @param device Outro Dispositivo para Comparação
     * @return Confirmação de Igualdade
     */
    public boolean equals(DeviceElement device)
    {
        return getName().equals(device.getName()) &&
               getType().equals(device.getType());
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
